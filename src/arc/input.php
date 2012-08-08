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
class PNArcInput extends PNArc implements PNBaseVisitable
{
	/**
	 * Constructor.
	 *
	 * @param   PNPlace          $input       The input Place.
	 * @param   PNTransition     $output      The output Transition.
	 * @param   PNArcExpression  $expression  The arc expression.
	 *
	 * @since   1.0
	 */
	public function __construct(PNPlace $input = null, PNTransition $output = null, PNArcExpression $expression = null)
	{
		$this->input = $input;
		$this->output = $output;

		parent::__construct($expression);
	}

	/**
	 * Set the input Place of this Arc.
	 *
	 * @param   PNPlace  $place  The input Place.
	 *
	 * @return  PNArcInput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setInput(PNPlace $place)
	{
		$this->input = $place;

		return $this;
	}

	/**
	 * Set the output Transition of this Arc.
	 *
	 * @param   PNTransition  $transition  The output Transition.
	 *
	 * @return  PNArcInput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOutput(PNTransition $transition)
	{
		$this->output = $transition;

		return $this;
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
			if (!is_null($this->input))
			{
				// The arc expression must evaluate to a colour in the colour set of the attached place.
				$expressionArgs = $this->expression->getArguments();
				$colorSet = $this->input->getColorSet()->getType();

				$diff = array_diff($expressionArgs, $colorSet);

				if (empty($diff))
				{
					return true;
				}
			}
		}

		return false;
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
