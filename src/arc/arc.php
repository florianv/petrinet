<?php
/**
 * @package     Petrinet
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Petri Net Arcs.
 *
 * @package     Petrinet
 * @subpackage  Arc
 * @since       1.0
 */
class PNArc implements PNArcBase
{
	/**
	 * @var    PNNode  The input Node of this Arc.
	 * @since  1.0
	 */
	protected $input;

	/**
	 * @var    PNNode  The output Node of this Arc.
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
	 * @param   PNNode           $input       The input Place.
	 * @param   PNNode           $output      The output Transition.
	 * @param   PNArcExpression  $expression  The arc's expression.
	 * @param   PNTypeManager    $manager     The type Manager.
	 *
	 * @since   1.0
	 */
	public function __construct(PNNode $input = null, PNNode $output = null, PNArcExpression $expression = null, PNTypeManager $manager = null)
	{
		// Set the input node.
		$this->input = $input;

		// Set the output node.
		$this->output = $output;

		// Use the given type manager, or create a new one.
		$this->typeManager = $manager ? $manager : new PNTypeManager;

		// Set the arc expression.
		$this->expression = $expression;
	}

	/**
	 * Set the input Node of this Arc.
	 *
	 * @param   PNNode  $input  The input Node.
	 *
	 * @return  PNArc  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setInput(PNNode $input)
	{
		$this->input = $input;

		return $this;
	}

	/**
	 * Get the input Node of this Arc.
	 *
	 * @return  PNNode  The input Node.
	 *
	 * @since   1.0
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * Check if the arc has an input Node
	 *
	 * @return  boolean  True if it has an input, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasInput()
	{
		return $this->input ? true : false;
	}

	/**
	 * Set the output Node of this Arc.
	 *
	 * @param   PNNode  $output  The output Node.
	 *
	 * @return  PNArcBase  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOutput(PNNode $output)
	{
		$this->output = $output;

		return $this;
	}

	/**
	 * Get the output Node of this Arc.
	 *
	 * @return  PNNode  The output Node.
	 *
	 * @since   1.0
	 */
	public function getOutput()
	{
		return $this->output;
	}

	/**
	 * Check if the arc has an output Node
	 *
	 * @return  boolean  True if it has an output, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasOutput()
	{
		return $this->output ? true : false;
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
	 * Assert the Arc is loaded.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function assertIsLoaded()
	{
		if (!$this->isLoaded())
		{
			throw new RuntimeException('Arc not loaded.');
		}
	}

	/**
	 * Check if the arc expression is valid (it supposes it has an expression).
	 *
	 * @return  boolean  True if it's the case, false otherwise.
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
		return $this->expression ? true : false;
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
		$visitor->visitArc($this);

		$this->output->accept($visitor);
	}
}
