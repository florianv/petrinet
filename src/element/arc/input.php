<?php
/**
 * @package     Petrinet
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Input Arcs.
 * Input Arcs are connected from a Place to a Transition.
 *
 * @package     Petrinet
 * @subpackage  Arc
 * @since       1.0
 */
class PNElementArcInput extends PNElementArc implements PNBaseVisitable
{
	/**
	 * Constructor.
	 *
	 * @param   PNElementPlace       $input   The input Place.
	 * @param   PNElementTransition  $output  The output Transition.
	 *
	 * @since   1.0
	 */
	public function __construct(PNElementPlace $input = null, PNElementTransition $output = null)
	{
		$this->input = $input;
		$this->output = $output;
	}

	/**
	 * Set the input Place of this Arc.
	 *
	 * @param   PNElementPlace  $place  The input Place.
	 *
	 * @return  PNElementArcInput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setInput(PNElementPlace $place)
	{
		$this->input = $place;

		return $this;
	}

	/**
	 * Set the output Transition of this Arc.
	 *
	 * @param   PNElementTransition  $transition  The output Transition.
	 *
	 * @return  PNElementArcInput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOutput(PNElementTransition $transition)
	{
		$this->output = $transition;

		return $this;
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
		$visitor->visitInputArc($this);
	}
}
