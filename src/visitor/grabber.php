<?php
/**
 * @package     Petrinet
 * @subpackage  Visitor
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * A visitor traversing a Petri Net and grabbing the different elements.
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
	 * @var    array  The Petri Net Arcs.
	 * @since  1.0
	 */
	protected $arcs = array();

	/**
	 * Constructor.
	 *
	 * @param   PNPetrinet  $net  The Petri Net.
	 *
	 * @since   1.0
	 */
	public function __construct(PNPetrinet $net)
	{
		parent::__construct();
		$net->accept($this);
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
	 * Perform the visit of an Arc.
	 *
	 * @param   PNArc  $arc  The Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function doVisitArc(PNArc $arc)
	{
		$this->arcs[] = $arc;
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
	 * Get the Arcs.
	 *
	 * @return  array  The Arcs.
	 *
	 * @since   1.0
	 */
	public function getArcs()
	{
		return $this->arcs;
	}
}
