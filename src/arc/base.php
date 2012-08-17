<?php
/**
 * @package     Petrinet
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Interface for Petri Net Arcs.
 *
 * @package     Petrinet
 * @subpackage  Arc
 * @since       1.0
 */
interface PNArcBase extends PNBaseVisitable
{
	/**
	 * Set the input Node of this Arc.
	 *
	 * @param   PNNode  $input  The input Node.
	 *
	 * @return  PNArcBase  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setInput(PNNode $input);

	/**
	 * Get the input Node of this Arc.
	 *
	 * @return  PNNode  The input Node.
	 *
	 * @since   1.0
	 */
	public function getInput();

	/**
	 * Check if the arc has an input Node
	 *
	 * @return  boolean  True if it has an input, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasInput();

	/**
	 * Set the output Node of this Arc.
	 *
	 * @param   PNNode  $output  The output Node.
	 *
	 * @return  PNArcBase  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOutput(PNNode $output);

	/**
	 * Get the output Node of this Arc.
	 *
	 * @return  PNNode  The output Node.
	 *
	 * @since   1.0
	 */
	public function getOutput();

	/**
	 * Check if the arc has an output Node
	 *
	 * @return  boolean  True if it has an output, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasOutput();
}
