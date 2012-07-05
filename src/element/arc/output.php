<?php
/**
 * @package     Petrinet
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Output Arcs.
 * Output Arcs are connected from a Transition to a Place.
 *
 * @package     Petrinet
 * @subpackage  Arc
 * @since       1.0
 */
class PNElementArcOutput extends PNElementArc implements PNBaseVisitable
{
	/**
	 * Set the input Transition of this Arc.
	 *
	 * @param   PNElementTransition  $transition  The input Transition.
	 *
	 * @return  PNElementArcOutput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setInput(PNElementTransition $transition)
	{
		$this->input = $transition;

		return $this;
	}

	/**
	 * Set the output Place of this Arc.
	 *
	 * @param   PNElementPlace  $place  The output Place.
	 *
	 * @return  PNElementArcOutput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOutput(PNElementPlace $place)
	{
		$this->output = $place;

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
		$visitor->visitOutputArc($this);
	}
}
