<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test Class for PNVariable.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNVariableTest extends TestCase
{
	/**
	 * @var    PNVariable  A PNVariable instance.
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

		$this->object = new PNVariable('test', 8);
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNVariable::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$var = new PNVariable('test', 'test');
		$name = TestReflection::getValue($var, 'name');
		$value = TestReflection::getValue($var, 'value');

		$this->assertEquals($name, 'test');
		$this->assertEquals($value, 'test');
	}

	/**
	 * Get the Variable name.
	 *
	 * @return  void
	 *
	 * @covers  PNVariable::getName
	 * @since   1.0
	 */
	public function testGetName()
	{
		$name = TestReflection::getValue($this->object, 'name');

		$this->assertEquals($name, $this->object->getName());
	}

	/**
	 * Set the Variable Value.
	 *
	 * @return  void
	 *
	 * @covers  PNVariable::setValue
	 * @since   1.0
	 */
	public function testSetValue()
	{
		// Try and integer
		$this->object->setValue(8);
		$value = TestReflection::getValue($this->object, 'value');

		$this->assertEquals($value, 8);

		// Try a string.
		$this->object->setValue('test');
		$value = TestReflection::getValue($this->object, 'value');

		$this->assertEquals($value, 'test');

		// Try a bool.
		$this->object->setValue(true);
		$value = TestReflection::getValue($this->object, 'value');

		$this->assertTrue($value);
	}

	/**
	 * Tests the exception thrown by the PNVariable::setValue method.
	 *
	 * @return  void
	 *
	 * @covers  PNVariable::setValue
	 * @since   1.0
	 * @expectedException InvalidArgumentException
	 */
	public function testSetValueException()
	{
		$this->object->setValue(array());
		$this->object->setValue(new stdClass);
	}

	/**
	 * Get the Variable Value.
	 *
	 * @return  void
	 *
	 * @covers  PNVariable::getValue
	 * @since   1.0
	 */
	public function testGetValue()
	{
		$value = TestReflection::getValue($this->object, 'value');

		$this->assertEquals($value, $this->object->getValue());
	}
}
