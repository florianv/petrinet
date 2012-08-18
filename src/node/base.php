<?php
/**
 * @package     Petrinet
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Interface for Petri Net Nodes (Places and Transitions).
 *
 * @package     Petrinet
 * @subpackage  Arc
 * @since       1.0
 */
interface PNNodeBase extends PNBaseVisitable
{
	/**
	 * Add an input Arc to this Node.
	 *
	 * @param   PNArc  $arc  The Arc.
	 *
	 * @return  PNNodeBase  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addInput(PNArc $arc);

	/**
	 * Get the input Arcs of this Node.
	 *
	 * @return  array  An array of Arcs.
	 *
	 * @since   1.0
	 */
	public function getInputs();

	/**
	 * Set the input Arcs of this Node.
	 *
	 * @param   array  $arcs  An array of Arcs.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setInputs(array $arcs);

	/**
	 * Check if the Node has at least an input Arc.
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasInput();

	/**
	 * Add an output Arc to this Node.
	 *
	 * @param   PNArc  $arc  Arc.
	 *
	 * @return  PNNodeBase  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addOutput(PNArc $arc);

	/**
	 * Get the output Arc of this Node.
	 *
	 * @return  array  An array of Arcs.
	 *
	 * @since   1.0
	 */
	public function getOutputs();

	/**
	 * Set the output Arcs of this Node.
	 *
	 * @param   array  $arcs  An array of Arcs.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setOutputs(array $arcs);

	/**
	 * Check if the Node has at least one output Arc.
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasOutput();

	/**
	 * Check if the Node is loaded.
	 *
	 * @return  boolean  True if loaded, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isLoaded();
}
