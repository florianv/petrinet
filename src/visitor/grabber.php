<?php
/**
 * @package     Petrinet
 * @subpackage  Visitor
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * A simple visitor traversing a Petri Net and grabbing the different elements.
 *
 * @package     Petrinet
 * @subpackage  Visitor
 * @since       1.0
 */
class PNVisitorGrabber extends PNBaseVisitor
{
	/**
	 * @var    array  The Petri Net places.
	 * @since  1.0
	 */
	protected $places = array();

	/**
	 * @var    array  The Petri Net Transitions.
	 * @since  1.0
	 */
	protected $transitions = array();

	/**
	 * @var    array  The Petri Net input Arcs.
	 * @since  1.0
	 */
	protected $inputArcs = array();

	/**
	 * @var    array  The Petri Net output Arcs.
	 * @since  1.0
	 */
	protected $outputArcs = array();

	/**
	 * Perform the visit of a Petri Net.
	 *
	 * @param   PNPetrinet  $net  The Petri net.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitPetrinet(PNPetrinet $net)
	{
		// No need to do anything.
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
	protected function doVisitPlace(PNPlace $place)
	{
		$this->places[] = $place;
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
	protected function doVisitTransition(PNTransition $transition)
	{
		$this->transitions[] = $transition;
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
	protected function doVisitInputArc(PNArcInput $inputArc)
	{
		$this->inputArcs[] = $inputArc;
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
	protected function doVisitOutputArc(PNArcOutput $outputArc)
	{
		$this->outputArcs[] = $outputArc;
	}

	/**
	 * Get the Places.
	 *
	 * @return  array  The Places
	 *
	 * @since   1.0
	 */
	public function getPlaces()
	{
		return $this->places;
	}

	/**
	 * Get the Transitions.
	 *
	 * @return  array  The Transitions
	 *
	 * @since   1.0
	 */
	public function getTransitions()
	{
		return $this->transitions;
	}

	/**
	 * Get the input Arcs.
	 *
	 * @return  array  The input Arcs.
	 *
	 * @since   1.0
	 */
	public function getInputArcs()
	{
		return $this->inputArcs;
	}

	/**
	 * Get the output Arcs.
	 *
	 * @return  array  The output Arcs.
	 *
	 * @since   1.0
	 */
	public function getOutputArcs()
	{
		return $this->outputArcs;
	}
}
