<?php
/**
 * @package     Petrinet
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Petri Net Arcs.
 *
 * @package     Petrinet
 * @subpackage  Petrinet
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
	 * @var    PNArcExpression  The arc expression.
	 * @since  1.0
	 */
	protected $expression;

	/**
	 * This value specifies how many tokens can transit through this Arc.
	 *
	 * @var    integer  The weight of this Arc.
	 * @since  1.0
	 */
	protected $weight = 1;

	/**
	 * Constructor.
	 *
	 * @param   PNArcExpression  $expression  The arc's expression.
	 *
	 * @since   1.0
	 */
	public function __construct(PNArcExpression $expression = null)
	{
		$this->expression = $expression;
	}

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

	/**
	 * Check if the arc expression is valid.
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @since   1.0
	 */
	abstract public function validateExpression();

	/**
	 * Check if the arc has an expression attached to it.
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasExpression()
	{
		return !is_null($this->expression);
	}

	/**
	 * Set the arc expression.
	 *
	 * @param   PNArcExpression  $expression  The Arc's expression.
	 *
	 * @return  PNArc  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setExpression(PNArcExpression $expression)
	{
		$this->expression = $expression;

		return $this;
	}

	/**
	 * Get the arc expression.
	 *
	 * @return  PNArcExpression  The Arc's expression.
	 *
	 * @since   1.0
	 */
	public function getExpression()
	{
		return $this->expression;
	}
}
