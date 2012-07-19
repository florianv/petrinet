<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test Class for PNElementVariable.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNElementVariableTest extends TestCase
{
	/**
	 * @var    PNElementVariable  A PNElementVariable instance.
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

		$this->object = new PNElementVariable('test', 8);
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNElementVariable::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$var = new PNElementVariable('test', 'test');
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
	 * @covers  PNElementVariable::getName
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
	 * @covers  PNElementVariable::setValue
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

		// Try an object.
		$caught = false;

		try
		{
			$this->object->setValue(new stdClass);
		}

		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);
	}

	/**
	 * Get the Variable Value.
	 *
	 * @return  void
	 *
	 * @covers  PNElementVariable::getValue
	 * @since   1.0
	 */
	public function testGetValue()
	{
		$value = TestReflection::getValue($this->object, 'value');

		$this->assertEquals($value, $this->object->getValue());
	}
}
