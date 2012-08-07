<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNGuard.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNGuardTest extends TestCase
{
	/**
	 * @var    PNGuard  A PNGuard instance.
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

		$this->object = new PNGuard;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$condition = new PNConditionComparisonEq;
		$variable = new PNVariable('test', 8);

		$guard = new PNGuard($condition, $variable, 8);

		$op = TestReflection::getValue($guard, 'condition');
		$var = TestReflection::getValue($guard, 'variable');
		$val = TestReflection::getValue($guard, 'value');

		$this->assertEquals($op, $condition);
		$this->assertEquals($var, $variable);
		$this->assertEquals($val, 8);
	}

	/**
	 * Set a Condition for this Guard.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::setCondition
	 * @since   1.0
	 */
	public function testSetCondition()
	{
		// Try a valid comparison condition.
		$condition = new PNConditionComparisonGt;
		$this->object->setCondition($condition);

		$this->assertEquals(TestReflection::getValue($this->object, 'condition'), $condition);
	}

	/**
	 * Tests the error thrown by the PNGuard::setCondition method.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::setCondition
	 *
	 * @since   1.0
	 *
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetOperatorException()
	{
		$this->object->setCondition(new stdClass);
	}

	/**
	 * Set a Variable for this Guard.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::setVariable
	 * @since   1.0
	 */
	public function testSetVariable()
	{
		// Try a valid variable.
		$variable = new PNVariable('test', 'test');
		$this->object->setVariable($variable);

		$this->assertEquals(TestReflection::getValue($this->object, 'variable'), $variable);
	}

	/**
	 * Tests the error thrown by the PNGuard::setVariable method.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::setVariable
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetVariableException()
	{
		$this->object->setVariable(new stdClass);
	}

	/**
	 * Set a PHP value (string/float/integer/boolean) to compare against.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::setValue
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
	}

	/**
	 * Tests the exception thrown by the PNGuard::setValue method.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::setValue
	 * @since   1.0
	 * @expectedException InvalidArgumentException
	 */
	public function testSetValueException()
	{
		$this->object->setValue(array());
		$this->object->setValue(new stdClass);
	}

	/**
	 * Assert the Guard is Loaded.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::assertIsLoaded
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
		TestReflection::setValue($this->object, 'condition', new PNConditionComparisonEq);

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
		TestReflection::setValue($this->object, 'variable', new PNVariable('test', 'test'));

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
		TestReflection::setValue($this->object, 'value', 8);

		$this->object->assertIsLoaded();
	}

	/**
	 * Execute the condition.
	 *
	 * @return  void
	 *
	 * @covers  PNGuard::execute
	 * @since   1.0
	 */
	public function testExecute()
	{
		// Create a random variable.
		$variable = new PNVariable('test', 'test');

		// Create a mocked condition.
		$condition  = $this->getMock('PNConditionComparison');

		$condition->expects($this->once())
			->method('execute')
			->with('test', 'test');

		// Set the guard operator, variable and value.
		TestReflection::setValue($this->object, 'condition', $condition);
		TestReflection::setValue($this->object, 'variable', $variable);
		TestReflection::setValue($this->object, 'value', 'test');

		$this->object->execute();
	}
}
