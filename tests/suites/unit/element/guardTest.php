<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNElementGuard.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNElementGuardTest extends TestCase
{
	/**
	 * @var    PNElementArc  A PNElementArc mock.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Setup.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new PNElementGuard;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNElementGuard::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$operator = new PNElementOperatorEq;
		$variable = new PNElementVariable('test', 8);

		$guard = new PNElementGuard($operator, $variable, 8);

		$op = TestReflection::getValue($guard, 'operator');
		$var = TestReflection::getValue($guard, 'variable');
		$val = TestReflection::getValue($guard, 'value');

		$this->assertEquals($op, $operator);
		$this->assertEquals($var, $variable);
		$this->assertEquals($val, 8);
	}

	/**
	 * Set an operator for this Guard.
	 *
	 * @return  void
	 *
	 * @covers  PNElementGuard::setOperator
	 * @since   1.0
	 */
	public function testSetOperator()
	{
		// Try a valid operator.
		$operator = new PNElementOperatorGt;
		$this->object->setOperator($operator);
		$this->assertEquals(TestReflection::getValue($this->object, 'operator'), $operator);

		// Try an invalid operator.
		$caught = false;

		try
		{
			$this->object->setOperator(new stdClass);
		}
		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);
	}

	/**
	 * Set a Variable for this Guard.
	 *
	 * @return  void
	 *
	 * @covers  PNElementGuard::setVariable
	 * @since   1.0
	 */
	public function testSetVariable()
	{
		// Try a valid variable.
		$variable = new PNElementVariable('test', 'test');
		$this->object->setVariable($variable);
		$this->assertEquals(TestReflection::getValue($this->object, 'variable'), $variable);

		// Try an invalid operator.
		$caught = false;

		try
		{
			$this->object->setVariable(new stdClass);
		}
		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);
	}

	/**
	 * Set a PHP value (string/float/integer/boolean) to compare against.
	 *
	 * @return  void
	 *
	 * @covers  PNElementGuard::setValue
	 * @since   1.0
	 */
	public function testSetValue()
	{
		// Try a string.
		$this->object->setValue('test');
		$this->assertEquals(TestReflection::getValue($this->object, 'value'), 'test');

		// Try a float.
		$this->object->setValue(8.2);
		$this->assertEquals(TestReflection::getValue($this->object, 'value'), 8.2);

		// Try a boolean.
		$this->object->setValue(true);
		$this->assertEquals(TestReflection::getValue($this->object, 'value'), true);

		// Try an array.
		$caught = false;
		try
		{
			$this->object->setValue(array());
		}

		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);
	}

	/**
	 * Assert the Guard is Loaded.
	 *
	 * @return  void
	 *
	 * @covers  PNElementGuard::assertIsLoaded
	 * @since   1.0
	 */
	public function testAssertIsLoaded()
	{
		// The guard created in setup is not loaded.
		$caught = false;

		try
		{
			$this->object->assertIsLoaded();
		}

		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);

		// Add an operator.
		$this->object->setOperator(new PNElementOperatorEq);

		$caught = false;

		try
		{
			$this->object->assertIsLoaded();
		}
		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);

		// Add a variable.
		$this->object->setVariable(new PNElementVariable('test', 'test'));

		$caught = false;

		try
		{
			$this->object->assertIsLoaded();
		}

		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);

		// Add a value to compare against.
		$this->object->setValue(8);

		$this->object->assertIsLoaded();
	}

	/**
	 * Execute the condition.
	 *
	 * @return  void
	 *
	 * @covers  PNElementGuard::execute
	 * @since   1.0
	 */
	public function testExecute()
	{
		// Create a random variable.
		$variable = new PNElementVariable('test', 'test');

		// Create a mocked operator.
		$operator  = $this->getMock('PNElementOperator');

		$operator->expects($this->once())
			->method('execute')
			->with('test', 'test');

		// Set the guard operator, variable and value.
		TestReflection::setValue($this->object, 'operator', $operator);
		TestReflection::setValue($this->object, 'variable', $variable);
		TestReflection::setValue($this->object, 'value', 'test');

		$this->object->execute();
	}
}
