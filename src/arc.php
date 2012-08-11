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
	 * @var    PNPlace|PNTransition  The input Place or Transition of this Arc.
	 * @since  1.0
	 */
	protected $input;

	/**
	 * @var    PNPlace|PNTransition  The output Place or Transition of this Arc.
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
	public function validateExpression()
	{
		if ($this->hasExpression())
		{
			// The arc expression arguments must match the input place/transition color set.
			$expressionArgs = $this->expression->getArguments();
			$colorSet = $this->input->getColorSet()->getType();

			$diff = array_diff($expressionArgs, $colorSet);

			if (empty($diff))
			{
				// The arc expression must evaluate to a colour in the output place/transition color set.
				$arguments = array();

				// Generate arguments.
				foreach ($expressionArgs as $argument)
				{
					// Create a random variable.
					$lambdaVar = 'test';

					// Cast the variable.
					settype($lambdaVar, $argument);

					$arguments[] = $lambdaVar;
				}

				// Execute the expression.
				try
				{
					$return = $this->expression->execute($arguments);
				}
				catch (Exception $e)
				{
					return false;
				}

				if (!is_array($return))
				{
					return false;
				}

				$types = array();

				foreach ($return as $value)
				{
					if (is_float($value))
					{
						$types[] = 'float';
					}

					else
					{
						$types[] = gettype($value);
					}
				}

				// Verify the returned values types are a sub-set of the output transition/place color set.
				$transitionColorSet = $this->output->getColorSet()->getType();
				$diff = array_diff($transitionColorSet, $types);

				if (count($diff) == (count($transitionColorSet) - count($types)))
				{
					return true;
				}
			}
		}

		return false;
	}

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
