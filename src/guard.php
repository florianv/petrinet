<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Petri Net Guards.
 * A Guard is an enabling condition associated with a Transition.
 * It Evaluates a Comparison condition between a PNVariable, and a PHP string/float/integer/boolean.
 * The PetriNet variable is always placed at the left and the PHP variable at the right.
 *
 * Example : var_1 >= 3
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
class PNGuard
{
	/**
	 * @var    PNConditionComparison  A comparison condition.
	 * @since  1.0
	 */
	protected $condition;

	/**
	 * @var    PNVariable  The Variable.
	 * @since  1.0
	 */
	protected $variable;

	/**
	 * @var    mixed  A PHP string/float/int/bool to compare against.
	 * @since  1.0
	 */
	protected $value;

	/**
	 * Constructor.
	 *
	 * @param   PNConditionComparison  $condition  The Comparison condition.
	 * @param   PNVariable      $variable   The Variable.
	 * @param   mixed                  $value      The Value to compare against.
	 *
	 * @since   1.0
	 */
	public function __construct(PNConditionComparison $condition = null, PNVariable $variable = null, $value = null)
	{
		$this->condition = $condition;
		$this->variable = $variable;
		$this->value = $value;
	}

	/**
	 * Set a Condition for this Guard.
	 *
	 * @param   PNConditionComparison  $condition  The Comparison condition.
	 *
	 * @return  PNGuard  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setCondition(PNConditionComparison $condition)
	{
		$this->condition = $condition;

		return $this;
	}

	/**
	 * Set a Variable for this Guard.
	 *
	 * @param   PNVariable  $variable  The Variable.
	 *
	 * @return  PNGuard  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setVariable(PNVariable $variable)
	{
		$this->variable = $variable;

		return $this;
	}

	/**
	 * Set a PHP value (string/float/integer/boolean) to compare against.
	 *
	 * @param   mixed  $value  The Value to compare against.
	 *
	 * @return  PNGuard  This method is chainable.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function setValue($value)
	{
		if (is_string($value) || is_numeric($value) || is_bool($value))
		{
			$this->value = $value;
			return $this;
		}

		throw new InvalidArgumentException('Value for the Guard is not a PHP string/float/int/bool: ' . $value);
	}

	/**
	 * Assert the Guard is Loaded.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function assertIsLoaded()
	{
		if (is_null($this->condition) || is_null($this->variable) || is_null($this->value))
		{
			throw new RuntimeException('The Guard is not loaded : Null variable, condition or Value.');
		}
	}

	/**
	 * Execute the condition.
	 *
	 * @return  boolean  True on success, false otherwise.
	 *
	 * @since   1.0
	 */
	public function execute()
	{
		// Assert the Guard is Loaded.
		$this->assertIsLoaded();

		// Execute the Condition.
		return $this->condition->execute($this->variable->getValue(), $this->value);
	}
}
