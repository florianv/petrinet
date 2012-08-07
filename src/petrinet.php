<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Nets.
 *
 * @package     Petrinet
 * @subpackage  Element
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
	 * Constructor.
	 *
	 * @param   string  $name  The Petri Net name.
	 *
	 * @since   1.0
	 */
	public function __construct($name)
	{
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
	 * @return  PNPlace  The Place.
	 *
	 * @since   1.0
	 */
	public function createPlace()
	{
		$place = new PNPlace;

		$this->places[] = $place;

		return $place;
	}

	/**
	 * Create a new Transition.
	 *
	 * @return  PNTransition  The Transition.
	 *
	 * @since   1.0
	 */
	public function createTransition()
	{
		$transition = new PNTransition;

		$this->transitions[] = $transition;

		return $transition;
	}

	/**
	 * Connect a place to a Transition or vice-versa.
	 *
	 * @param   mixed    $from    The source Place or Transition.
	 * @param   mixed    $to      The target Place or Transition.
	 * @param   integer  $weight  The Arc weight.
	 *
	 * @return  object  The Arc object.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function connect($from, $to, $weight = 1)
	{
		// Input Arc.
		if ($from instanceof PNPlace && $to instanceof PNTransition)
		{
			$arc = new PNArcInput($from, $to);

			$arc->setWeight($weight);

			$this->inputArcs[] = $arc;
		}

		// Output Arc.
		elseif ($from instanceof PNTransition && $to instanceof PNPlace)
		{
			$arc = new PNArcOutput($from, $to);

			$arc->setWeight($weight);

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
