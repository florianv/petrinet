<?php
/**
 * @package     Petrinet
 * @subpackage  Base
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base class for Visitors traversing Petri Nets using depth first algorithm.
 *
 * @package     Petrinet
 * @subpackage  Base
 * @see         http://en.wikipedia.org/wiki/Visitor_pattern
 * @since       1.0
 */
abstract class PNBaseVisitor
{
	/**
	 * @var    SplObjectStorage  The visited Places.
	 * @since  1.0
	 */
	protected $visitedPlaces;

	/**
	 * @var    SplObjectStorage  The visited Transitions.
	 * @since  1.0
	 */
	protected $visitedTransitions;

	/**
	 * @var    SplObjectStorage  The visited Arcs.
	 * @since  1.0
	 */
	protected $visitedArcs;

	/**
	 * Constructor.
	 *
	 * @since  1.0
	 */
	public function __construct()
	{
		$this->visitedPlaces = new SplObjectStorage;
		$this->visitedTransitions = new SplObjectStorage;
		$this->visitedArcs = new SplObjectStorage;
	}

	/**
	 * Perform the visit of a Petri Net.
	 *
	 * @param   PNPetrinet  $net  The Petri net.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract public function visitPetrinet(PNPetrinet $net);

	/**
	 * Visit a Place.
	 *
	 * @param   PNPlace  $place  The Place.
	 *
	 * @return  boolean  False if the Place has been already visited.
	 *
	 * @since   1.0
	 */
	public function visitPlace(PNPlace $place)
	{
		// Ensure the Place hasn't been already visited.
		if ($this->visitedPlaces->contains($place))
		{
			return false;
		}

		// Add the visited Place to the visited stack.
		$this->visitedPlaces->attach($place);

		// Perfom the visit.
		$this->doVisitPlace($place);

		return true;
	}

	/**
	 * Perform the visit of a Place.
	 *
	 * @param   PNPlace  $place  The Place.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract protected function doVisitPlace(PNPlace $place);

	/**
	 * Visit a Transition.
	 *
	 * @param   PNTransition  $transition  The Transition.
	 *
	 * @return  boolean  False if the Transition has been already visited.
	 *
	 * @since   1.0
	 */
	public function visitTransition(PNTransition $transition)
	{
		// Ensure the Transition hasn't been already visited.
		if ($this->visitedTransitions->contains($transition))
		{
			return false;
		}

		// Add the visited Transition to the visited stack.
		$this->visitedTransitions->attach($transition);

		// Perfom the visit.
		$this->doVisitTransition($transition);

		return true;
	}

	/**
	 * Perform the visit of a Transition.
	 *
	 * @param   PNTransition  $transition  The Transition.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract protected function doVisitTransition(PNTransition $transition);

	/**
	 * Visit an Arc.
	 *
	 * @param   PNArc  $arc  The Arc.
	 *
	 * @return  boolean  False if the Arc has been already visited.
	 *
	 * @since   1.0
	 */
	public function visitArc(PNArc $arc)
	{
		// Ensure the arc hasn't been already visited.
		if ($this->visitedArcs->contains($arc))
		{
			return false;
		}

		// Add the visited arc to the visited stack.
		$this->visitedArcs->attach($arc);

		// Perfom the visit.
		$this->doVisitArc($arc);

		return true;
	}

	/**
	 * Perform the visit of an Arc.
	 *
	 * @param   PNArc  $arc  The Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract protected function doVisitArc(PNArc $arc);
}
