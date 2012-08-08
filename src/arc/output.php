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
class PNArcOutput extends PNArc implements PNBaseVisitable
{
	/**
	 * Constructor.
	 *
	 * @param   PNTransition     $input       The input Place.
	 * @param   PNPlace          $output      The output Transition.
	 * @param   PNArcExpression  $expression  The arc expression.
	 *
	 * @since   1.0
	 */
	public function __construct(PNTransition $input = null, PNPlace $output = null, PNArcExpression $expression = null)
	{
		$this->input = $input;
		$this->output = $output;

		parent::__construct($expression);
	}

	/**
	 * Set the input Transition of this Arc.
	 *
	 * @param   PNTransition  $transition  The input Transition.
	 *
	 * @return  PNArcOutput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setInput(PNTransition $transition)
	{
		$this->input = $transition;

		return $this;
	}

	/**
	 * Set the output Place of this Arc.
	 *
	 * @param   PNPlace  $place  The output Place.
	 *
	 * @return  PNArcOutput  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOutput(PNPlace $place)
	{
		$this->output = $place;

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
			if (!is_null($this->output))
			{
				// The arc expression must evaluate to a colour in the colour set of the attached place.
				$expressionArgs = $this->expression->getArguments();
				$colorSet = $this->output->getColorSet()->getType();

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
		$visitor->visitOutputArc($this);
	}
}
