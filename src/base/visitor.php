<?php
/**
 * @package     Petrinet
 * @subpackage  Base
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Interface for Visitors.
 *
 * @package     Petrinet
 * @subpackage  Base
 * @see         http://en.wikipedia.org/wiki/Visitor_pattern
 * @since       1.0
 */
interface PNBaseVisitor
{
	/**
	 * Visit a Petri Net.
	 *
	 * @param   PNElementPetrinet  $net  The Petri Net.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitNet(PNElementPetrinet $net);

	/**
	 * Visit a Place.
	 *
	 * @param   PNElementPlace  $place  The Place.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitPlace(PNElementPlace $place);

	/**
	 * Visit a Transition.
	 *
	 * @param   PNElementTransition  $transition  The Transition.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitTransition(PNElementTransition $transition);

	/**
	 * Visit an Input Arc.
	 *
	 * @param   PNElementArcInput  $inputArc  The Input Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitInputArc(PNElementArcInput $inputArc);

	/**
	 * Visit an Output Arc.
	 *
	 * @param   PNElementArcOutput  $outputArc  The Output Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitOutputArc(PNElementArcOutput $outputArc);
}
