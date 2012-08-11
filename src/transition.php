<?php
/**
 * @package     Petrinet
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Transitions.
 *
 * @package     Petrinet
 * @subpackage  Petrinet
 * @since       1.0
 */
class PNTransition implements PNBaseVisitable
{
	/**
	 * @var    array  The input Arcs of this Transition.
	 * @since  1.0
	 */
	protected $inputs;

	/**
	 * @var    array  The ouput Arcs of this Transition.
	 * @since  1.0
	 */
	protected $outputs;

	/**
	 * @var    PNColorSet  The Transition color set.
	 * @since  1.0
	 */
	protected $colorSet;

	/**
	 * Constructor.
	 *
	 * @param   PNColorSet  $colorSet  The transition color set.
	 * @param   array       $inputs    The input arcs of this Transition (PNArcInput).
	 * @param   array       $outputs   The output arcs of this Transition (PNArcOutput).
	 *
	 * @since   1.0
	 */
	public function __construct(PNColorSet $colorSet = null, array $inputs = array(), array $outputs = array())
	{
		// Take the given color set or create an empty one.
		$this->colorSet = $colorSet ? $colorSet : new PNColorSet;

		if (empty($inputs))
		{
			$this->inputs = $inputs;
		}

		else
		{
			foreach ($inputs as $input)
			{
				$this->addInput($input);
			}
		}

		if (empty($outputs))
		{
			$this->outputs = $outputs;
		}

		else
		{
			foreach ($outputs as $output)
			{
				$this->addOutput($output);
			}
		}
	}

	/**
	 * Add an input Arc to this Transition.
	 *
	 * @param   PNArcInput  $arc  The input Arc.
	 *
	 * @return  PNTransition This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addInput(PNArcInput $arc)
	{
		$this->inputs[] = $arc;

		return $this;
	}

	/**
	 * Get the input Arcs of this Transition.
	 *
	 * @return  array  An array of PNArc objects.
	 *
	 * @since   1.0
	 */
	public function getInputs()
	{
		return $this->inputs;
	}

	/**
	 * Add an ouput Arc to this Transition.
	 *
	 * @param   PNArcOutput  $arc  The input Arc.
	 *
	 * @return  PNTransition This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addOutput(PNArcOutput $arc)
	{
		$this->outputs[] = $arc;

		return $this;
	}

	/**
	 * Get the output Arcs of this Transition.
	 *
	 * @return  array  An array of PNArc objects.
	 *
	 * @since   1.0
	 */
	public function getOutputs()
	{
		return $this->outputs;
	}

	/**
	 * Set the color set of this Transition.
	 *
	 * @param   PNColorSet  $set  The color set.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setColorSet(PNColorSet $set)
	{
		$this->colorSet = $set;

		return $this;
	}

	/**
	 * Get the color set of this Transition.
	 *
	 * @return  PNColorSet  The color set.
	 *
	 * @since   1.0
	 */
	public function getColorSet()
	{
		return $this->colorSet;
	}

	/**
	 * Verify if this Transition is Enabled.
	 *
	 * @return  boolean  True is enabled, false if not.
	 *
	 * @since   1.0
	 */
	public function isEnabled()
	{
		if (empty($this->inputs) || empty($this->outputs))
		{
			return false;
		}

		// Get the transition color set.
		$setTypes = $this->colorSet->getType();

		// A transition is enabled if each input place p of t is marked with at least
		// w(p,t) tokens, where w(p,t) is the weight of the arc from p to t.
		foreach ($this->inputs as $arc)
		{
			// Get the input place
			$place = $arc->getInput();

			if ($place->getTokenCount() < $arc->getWeight())
			{
				return false;
			}

			// Verify the arc expression is valid.
			// @todo remove double check in arc dovalidatexpression
			if ($arc->hasExpression())
			{
				if (!$arc->validateExpression())
				{
					return false;
				}
			}

			// Transition is enabled if we can find a binding so that each input arc expression evaluates
			// to one or more colours in the transition color set.

			// Get the place tokens.
			$tokens = $place->getTokens();

			// Get a random token.
			shuffle($tokens);
			$token = $tokens[0];

			// Get the token color.
			$color = $token->getColor()->getData();

			// Execute the arc expression.
			$return = $arc->getExpression()->execute($color);

			// Build an array containing the type of the returned values.
			$data = array();

			foreach ($return as $value)
			{
				if (is_float($value))
				{
					$data[] = 'float';
				}

				else
				{
					$data[] = gettype($value);
				}
			}

			// Remove the returned types from the transition color set.
			$setTypes = array_diff($setTypes, $data);

			// If the set is empty it means we can create a token matching the transition color set.
			if (empty($setTypes))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Execute (fire) the Transition (it supposes it is enabled).
	 *
	 * @return  boolean  False if it's the last Transition, true if not.
	 *
	 * @since   1.0
	 */
	public function execute()
	{

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
		$visitor->visitTransition($this);
	}
}
