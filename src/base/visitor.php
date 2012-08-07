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
	 * @param   PNPetrinet  $net  The Petri Net.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitNet(PNPetrinet $net);

	/**
	 * Visit a Place.
	 *
	 * @param   PNPlace  $place  The Place.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitPlace(PNPlace $place);

	/**
	 * Visit a Transition.
	 *
	 * @param   PNTransition  $transition  The Transition.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitTransition(PNTransition $transition);

	/**
	 * Visit an Input Arc.
	 *
	 * @param   PNArcInput  $inputArc  The Input Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitInputArc(PNArcInput $inputArc);

	/**
	 * Visit an Output Arc.
	 *
	 * @param   PNArcOutput  $outputArc  The Output Arc.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function visitOutputArc(PNArcOutput $outputArc);
}
