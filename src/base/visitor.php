<?php
/**
 * @package     Petrinet
 * @subpackage  Base
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base class for Visitors traversing Petri Nets using depth first search algorithm.
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
	 * @var    SplObjectStorage  The visited input Arcs.
	 * @since  1.0
	 */
	protected $visitedInputArcs;

	/**
	 * @var    SplObjectStorage  The visited output Arcs.
	 * @since  1.0
	 */
	protected $visitedOutputArcs;

	/**
	 * Constructor.
	 *
	 * @since  1.0
	 */
	public function __construct()
	{
		$this->visitedPlaces = new SplObjectStorage;
		$this->visitedTransitions = new SplObjectStorage;
		$this->visitedInputArcs = new SplObjectStorage;
		$this->visitedOutputArcs = new SplObjectStorage;
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
	 * Visit an Input Arc.
	 *
	 * @param   PNArcInput  $inputArc  The Input Arc.
	 *
	 * @return  boolean  False if the input Arc has been already visited.
	 *
	 * @since   1.0
	 */
	public function visitInputArc(PNArcInput $inputArc)
	{
		// Ensure the Input Arc hasn't been already visited.
		if ($this->visitedInputArcs->contains($inputArc))
		{
			return false;
		}

		// Add the visited Input Arc to the visited stack.
		$this->visitedInputArcs->attach($inputArc);

		// Perfom the visit.
		$this->doVisitInputArc($inputArc);

		return true;
	}

	/**
	 * Perform the visit of an Input Arc.
	 *
	 * @param   PNArcInput  $inputArc  The Input Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract protected function doVisitInputArc(PNArcInput $inputArc);

	/**
	 * Visit an Output Arc.
	 *
	 * @param   PNArcOutput  $outputArc  The Output Arc.
	 *
	 * @return  boolean  False if the output Arc has been already visited.
	 *
	 * @since   1.0
	 */
	public function visitOutputArc(PNArcOutput $outputArc)
	{
		// Ensure the output Arc hasn't been already visited.
		if ($this->visitedOutputArcs->contains($outputArc))
		{
			return false;
		}

		// Add the visited output Arc to the visited stack.
		$this->visitedOutputArcs->attach($outputArc);

		// Perfom the visit.
		$this->doVisitOutputArc($outputArc);

		return true;
	}

	/**
	 * Perform the visit of an Output Arc.
	 *
	 * @param   PNArcOutput  $outputArc  The Output Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract protected function doVisitOutputArc(PNArcOutput $outputArc);
}
