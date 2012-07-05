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
 * It Evaluates a Comparison condition between a PNElementVariable, and a PHP string/float/integer/boolean.
 * The PetriNet variable is always placed at the left and the PHP variable at the right.
 *
 * Example : var_1 >= 3
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
class PNElementGuard
{
	/**
	 * @var    PNElementOperator  The Comparison Operator.
	 * @since  1.0
	 */
	protected $operator;

	/**
	 * @var    PNElementVariable  The Variable.
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
	 * @param   PNElementOperator  $operator  The Comparison Operator.
	 * @param   PNElementVariable  $variable  The Variable.
	 * @param   mixed              $value     The Value to compare against.
	 *
	 * @since   1.0
	 */
	public function __construct(PNElementOperator $operator = null, PNElementVariable $variable = null, $value = null)
	{
		$this->operator = $operator;
		$this->variable = $variable;
		$this->value = $value;
	}

	/**
	 * Set an operator for this Guard.
	 *
	 * @param   PNElementOperator  $operator  The Comparison Operator.
	 *
	 * @return  PNElementGuard  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setOperator(PNElementOperator $operator)
	{
		$this->operator = $operator;

		return $this;
	}

	/**
	 * Set a Variable for this Guard.
	 *
	 * @param   PNElementVariable  $variable  The Variable.
	 *
	 * @return  PNElementGuard  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setVariable(PNElementVariable $variable)
	{
		$this->variable = $variable;

		return $this;
	}

	/**
	 * Set a PHP value (string/float/integer/boolean) to compare against.
	 *
	 * @param   mixed  $value  The Value to compare against.
	 *
	 * @return  PNElementGuard  This method is chainable.
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
	protected function assertIsLoaded()
	{
		if (is_null($this->operator) || is_null($this->variable) || is_null($this->value))
		{
			throw new RuntimeException('The Guard is not loaded : Null variable, operator or Value.');
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
		return $this->operator->execute($this->variable->getValue(), $this->value);
	}
}
