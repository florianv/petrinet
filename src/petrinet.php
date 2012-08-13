<?php
/**
 * @package     Petrinet
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Nets.
 *
 * @package     Petrinet
 * @subpackage  Petrinet
 * @since       1.0
 */
class PNPetrinet implements PNBaseVisitable
{
	/**
	 * @var    PNPetrinet  The Petri Net instances.
	 * @since  1.0
	 */
	protected static $instances = array();

	/**
	 * @var    string  The Petri Net name.
	 * @since  1.0
	 */
	protected $name;

	/**
	 * @var    array  The Petri Net Places.
	 * @since  1.0
	 */
	protected $places = array();

	/**
	 * @var    array  The Petri Net Transitions.
	 * @since  1.0
	 */
	protected $transitions = array();

	/**
	 * @var    array  The Input Arcs.
	 * @since  1.0
	 */
	protected $inputArcs = array();

	/**
	 * @var    array  The Output Arcs.
	 * @since  1.0
	 */
	protected $outputArcs = array();

	/**
	 * @var    PNTypeManager  A type Manager for this petri net.
	 * @since  1.0
	 */
	protected $typeManager;

	/**
	 * Constructor.
	 *
	 * @param   string         $name     The Petri Net name.
	 * @param   PNTypeManager  $manager  The type Manager.
	 *
	 * @since   1.0
	 */
	public function __construct($name, PNTypeManager $manager = null)
	{
		// Use the given type manager, or create a new one.
		$this->typeManager = $manager ? $manager : new PNTypeManager;

		$this->name = $name;
	}

	/**
	 * Get an Instance (or create it).
	 *
	 * @param   string  $name  The Petri Net name.
	 *
	 * @return  PNPetrinet
	 *
	 * @since   1.0
	 */
	public static function getInstance($name)
	{
		if (empty(self::$instances[$name]))
		{
			self::$instances[$name] = new PNPetrinet($name);
		}

		return self::$instances[$name];
	}

	/**
	 * Create a new Place.
	 *
	 * @param   PNColorSet  $colorSet  The place color set.
	 *
	 * @return  PNPlace  The Place.
	 *
	 * @since   1.0
	 */
	public function createPlace(PNColorSet $colorSet = null)
	{
		$place = new PNPlace($colorSet);

		$this->places[] = $place;

		return $place;
	}

	/**
	 * Create a new Color set.
	 *
	 * @param   array  $type  A tuple of types.
	 *
	 * @return  PNColorSet  The Color set.
	 *
	 * @since   1.0
	 */
	public function createColorSet(array $type = array())
	{
		return new PNColorSet($type, $this->typeManager);
	}

	/**
	 * Create a new Transition.
	 *
	 * @param   PNColorSet  $colorSet  The place color set.
	 *
	 * @return  PNTransition  The Transition.
	 *
	 * @since   1.0
	 */
	public function createTransition(PNColorSet $colorSet = null)
	{
		$transition = new PNTransition($colorSet);

		$this->transitions[] = $transition;

		return $transition;
	}

	/**
	 * Connect a place to a Transition or vice-versa.
	 *
	 * @param   PNPlace|PNTransition  $from        The source Place or Transition.
	 * @param   PNPlace|PNTransition  $to          The target Place or Transition.
	 * @param   PNArcExpression       $expression  The arc's expression.
	 *
	 * @return  object  The Arc object.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function connect($from, $to, PNArcExpression $expression = null)
	{
		// If an arc expression is given.
		if ($expression)
		{
			// Inject the type manager.
			$expression->setTypeManager($this->typeManager);
		}

		// Input Arc.
		if ($from instanceof PNPlace && $to instanceof PNTransition)
		{
			// Create the arc, inject the expression and type manager.
			$arc = new PNArcInput($from, $to, $expression, $this->typeManager);

			// Store it.
			$this->inputArcs[] = $arc;
		}

		// Output Arc.
		elseif ($from instanceof PNTransition && $to instanceof PNPlace)
		{
			// Create the arc, inject the expression and type manager.
			$arc = new PNArcOutput($from, $to, $expression, $this->typeManager);

			// Store it.
			$this->outputArcs[] = $arc;
		}

		else
		{
			throw new InvalidArgumentException('An arc connect only a Place to a Transition or vice-versa.');
		}

		// Add the Arc as an ouput Arc of $from and an input Arc of $to.
		$from->addOutput($arc);
		$to->addInput($arc);

		return $arc;
	}

	/**
	 * Ge the Petri Net name.
	 *
	 * @return  string  The name.
	 *
	 * @since   1.0
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Ge the Petri Net Places.
	 *
	 * @return  array  The Places.
	 *
	 * @since   1.0
	 */
	public function getPlaces()
	{
		return $this->places;
	}

	/**
	 * Ge the Petri Net Transitions.
	 *
	 * @return  array  The Transitions.
	 *
	 * @since   1.0
	 */
	public function getTransitions()
	{
		return $this->transitions;
	}

	/**
	 * Ge the Output Arcs.
	 *
	 * @return  array  The Output Arcs.
	 *
	 * @since   1.0
	 */
	public function getOuputArcs()
	{
		return $this->outputArcs;
	}

	/**
	 * Ge the Input Arcs.
	 *
	 * @return  array  The Input Arcs.
	 *
	 * @since   1.0
	 */
	public function getInputArcs()
	{
		return $this->inputArcs;
	}

	/**
	 * Set the type Manager of this Petri net.
	 *
	 * @param   PNTypeManager  $manager  The type Manager.
	 *
	 * @return  PNPetrinet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setTypeManager(PNTypeManager $manager)
	{
		$this->typeManager = $manager;

		return $this;
	}

	/**
	 * Get the type Manager of this Petri net.
	 *
	 * @return  PNTypeManager  $manager  The type manager.
	 *
	 * @since   1.0
	 */
	public function getTypeManager()
	{
		return $this->typeManager;
	}

	/**
	 * Accept the Visitor.
	 *
	 * @param   PNBaseVisitor  $visitor  The Visitor.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function accept(PNBaseVisitor $visitor)
	{
		$visitor->visitNet($this);
	}
}
