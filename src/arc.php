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
	 * @var    PNTypeManager  The type Manager.
	 * @since  1.0
	 */
	protected $typeManager;

	/**
	 * Constructor.
	 *
	 * @param   PNPlace|PNTransition  $input       The input Place.
	 * @param   PNPlace|PNTransition  $output      The output Transition.
	 * @param   PNArcExpression       $expression  The arc's expression.
	 * @param   PNTypeManager         $manager     The type Manager.
	 *
	 * @since   1.0
	 */
	public function __construct($input = null, $output = null, PNArcExpression $expression = null, PNTypeManager $manager = null)
	{
		$this->input = $input;
		$this->output = $output;

		// Use the given type manager, or create a new one.
		$this->typeManager = $manager ? $manager : new PNTypeManager;

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
	 * Check if the arc has an input Place or Transition.
	 *
	 * @return  boolean  True if it has an input, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasInput()
	{
		return !is_null($this->input);
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
	 * Check if the arc has an output Place or Transition.
	 *
	 * @return  boolean  True if it has an output, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasOutput()
	{
		return !is_null($this->output);
	}

	/**
	 * Check if the arc is loaded.
	 * It means it has an input and output.
	 *
	 * @return  boolean  True if loaded, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isLoaded()
	{
		return $this->hasInput() && $this->hasOutput();
	}

	/**
	 * Check if the arc expression is valid (it supposes it has an expression).
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @throws  UnexpectedValueException
	 *
	 * @since   1.0
	 */
	public function validateExpression()
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
				// If it's a basic type.
				if ($this->typeManager->isBasicType($argument))
				{
					// Create a random variable.
					$lambdaVar = 'test';

					// Cast the variable.
					settype($lambdaVar, $argument);
				}

				// Custom type.
				elseif ($this->typeManager->isCustomType($argument))
				{
					$object = $this->typeManager->getCustomTypeObject($argument);
					$lambdaVar = $object->test();
				}

				// Object type.
				else
				{
					$lambdaVar = new $argument;
				}

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

			// If the returned array if not an array, return false.
			if (!is_array($return))
			{
				return false;
			}

			// Get the type of the output Color set.
			$outputColorSet = $this->output->getColorSet()->getType();

			$types = array();

			// Get the type of the returned values.
			for ($i = 0; $i < count($return); $i++)
			{
				$types = array_merge($this->typeManager->getTypes($return[$i]), $types);
			}

			$diff = array_diff($outputColorSet, $types);

			if (count($diff) < count($outputColorSet))
			{
				return true;
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
