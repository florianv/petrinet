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
	 * @var    PNPlace  The Petri Net Start Place.
	 * @since  1.0
	 */
	protected $startPlace;

	/**
	 * @var    PNTypeManager  A type Manager for this petri net.
	 * @since  1.0
	 */
	protected $typeManager;

	/**
	 * @var    PNVisitorGrabber  A PNVisitorGrabber instance.
	 * @since  1.0
	 */
	protected $grabber;

	/**
	 * Constructor.
	 *
	 * @param   string         $name        The Petri Net name.
	 * @param   PNPlace        $startPlace  The Petri Net Start Place.
	 * @param   PNTypeManager  $manager     The type Manager.
	 *
	 * @since   1.0
	 */
	public function __construct($name, PNPlace $startPlace = null, PNTypeManager $manager = null)
	{
		// Use the given type manager, or create a new one.
		$this->typeManager = $manager ? $manager : new PNTypeManager;

		// Set the Petri Net name.
		$this->name = $name;

		// Set the Start Place.
		$this->startPlace = $startPlace;
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
		return new PNPlace($colorSet);
	}

	/**
	 * Create a new Token.
	 *
	 * @param   PNColor  $color  The token color.
	 *
	 * @return  PNToken  The Token.
	 *
	 * @since   1.0
	 */
	public function createToken(PNColor $color = null)
	{
		return new PNToken($color);
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
		return new PNTransition($colorSet);
	}

	/**
	 * Connect a place to a Transition or vice-versa.
	 *
	 * @param   PNNode           $from        The source Place or Transition.
	 * @param   PNNode           $to          The target Place or Transition.
	 * @param   PNArcExpression  $expression  The arc's expression.
	 *
	 * @return  PNArc  The Arc object.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function connect(PNNode $from, PNNode $to, PNArcExpression $expression = null)
	{
		// Check $from and $to are both colored/basic.
		if ($from->isColoredMode() != $to->isColoredMode())
		{
			throw new InvalidArgumentException('From and to are not compatible, one is colored, the other no.');
		}

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
			$arc = new PNArc($from, $to, $expression, $this->typeManager);
		}

		// Output Arc.
		elseif ($from instanceof PNTransition && $to instanceof PNPlace)
		{
			// Create the arc, inject the expression and type manager.
			$arc = new PNArc($from, $to, $expression, $this->typeManager);
		}

		else
		{
			throw new InvalidArgumentException('An arc connects only a Place to a Transition or vice-versa.');
		}

		// Add the Arc as an ouput Arc of $from and an input Arc of $to.
		$from->addOutput($arc);
		$to->addInput($arc);

		return $arc;
	}

	/**
	 * Set the Petri Net start Place.
	 *
	 * @param   PNPlace  $place  The Petri net start place.
	 *
	 * @return  PNPetrinet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setStartPlace(PNPlace $place)
	{
		$this->startPlace = $place;

		return $this;
	}

	/**
	 * Set the Petri Net start Place.
	 *
	 * @return  PNPlace  The Petri net start place.
	 *
	 * @since   1.0
	 */
	public function getStartPlace()
	{
		return $this->startPlace;
	}

	/**
	 * Check if the Petri Net has a start Place.
	 *
	 * @return  boolean  True if it has a start Place, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasStartPlace()
	{
		return $this->startPlace ? true : false;
	}

	/**
	 * Assert the Petri Net has a start Place.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function assertHasStartPlace()
	{
		if (!$this->hasStartPlace())
		{
			throw new RuntimeException('The Petri Net has no start Place.');
		}
	}

	/**
	 * Get the Petri Net name.
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
	 * Check if a grabber is set.
	 *
	 * @return  boolean  True if a grabber is set, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasGrabber()
	{
		return $this->grabber ? true : false;
	}

	/**
	 * Grab the Petri net elements.
	 *
	 * @param   boolean  $reload  True to re-grab all the elements.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	protected function doGrab($reload)
	{
		if ($reload || !$this->hasGrabber())
		{
			// Assert the Petri net has a start Place.
			$this->assertHasStartPlace();

			// Grab the elements.
			$grabber = new PNVisitorGrabber;
			$this->accept($grabber);
			$this->grabber = $grabber;
		}
	}

	/**
	 * Get the Petri net Places.
	 *
	 * @param   boolean  $reload  True to re-grab all the elements.
	 *
	 * @return  array  An array of Petri Net Places.
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function getPlaces($reload = true)
	{
		$this->doGrab($reload);

		return $this->grabber->getPlaces();
	}

	/**
	 * Get the Petri net Transitions.
	 *
	 * @param   boolean  $reload  True to re-grab all the elements.
	 *
	 * @return  array  An array of Petri Net Transitions.
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function getTransitions($reload = true)
	{
		$this->doGrab($reload);

		return $this->grabber->getTransitions();
	}

	/**
	 * Get the Petri net Arcs.
	 *
	 * @param   boolean  $reload  True to re-grab all the elements.
	 *
	 * @return  array  An array of Petri Net Arcs.
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function getArcs($reload = true)
	{
		$this->doGrab($reload);

		return $this->grabber->getArcs();
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
		$visitor->visitPetrinet($this);

		$this->startPlace->accept($visitor);
	}
}
