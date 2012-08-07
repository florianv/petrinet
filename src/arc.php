<?php
/**
 * @package     Petrinet
 * @subpackage  ...
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Petri Net Arcs.
 *
 * @package     Petrinet
 * @subpackage  ...
 * @since       1.0
 */
abstract class PNArc
{
	/**
	 * @var    object  The input Place or Transition of this Arc.
	 * @since  1.0
	 */
	protected $input;

	/**
	 * @var    object  The output Place or Transition of this Arc.
	 * @since  1.0
	 */
	protected $output;

	/**
	 * This value specifies how many tokens can transit through this Arc.
	 *
	 * @var    integer  The weight of this Arc.
	 * @since  1.0
	 */
	protected $weight = 1;

	/**
	 * Get the input Place or Transition of this Arc.
	 *
	 * @return  object  The input Place or Transition.
	 *
	 * @since   1.0
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * Get the output Place or Transition of this Arc.
	 *
	 * @return  object  The output Place or Transition.
	 *
	 * @since   1.0
	 */
	public function getOutput()
	{
		return $this->output;
	}

	/**
	 * Set the weight of this Arc.
	 *
	 * @param   integer  $weight  The Arc's weight.
	 *
	 * @return  PNArc  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setWeight($weight)
	{
		$this->weight = $weight;

		return $this;
	}

	/**
	 * Get the weight of this Arc.
	 *
	 * @return  integer  The Arc's weight.
	 *
	 * @since   1.0
	 */
	public function getWeight()
	{
		return $this->weight;
	}
}
