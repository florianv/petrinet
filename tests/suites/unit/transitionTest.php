<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNTransition.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNTransitionTest extends TestCase
{
	/**
	 * @var    PNTransition  A PNTransition instance.
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

		$this->object = new PNTransition;
	}

	/**
	 * Add an input Arc to this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::addInput
	 * @since   1.0
	 */
	public function testAddInput()
	{
		$input = new PNArcInput;
		$this->object->addInput($input);
		$inputs = TestReflection::getValue($this->object, 'inputs');

		$this->assertEquals($inputs[0], $input);

		$input = new PNArcInput;
		$this->object->addInput($input);
		$inputs = TestReflection::getValue($this->object, 'inputs');
		$this->assertEquals($inputs[1], $input);
	}

	/**
	 * Tests the error thrown by the PNTransition::addInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::addInput
	 *
	 * @since   1.0
	 *
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAddInputError()
	{
		$this->object->addInput(new stdClass);
	}

	/**
	 * Add an ouput Arc to this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::addOutput
	 * @since   1.0
	 */
	public function testAddOutput()
	{
		$output = new PNArcOutput;
		$this->object->addOutput($output);
		$outputs = TestReflection::getValue($this->object, 'outputs');

		$this->assertEquals($outputs[0], $output);

		$output = new PNArcOutput;
		$this->object->addOutput($output);
		$outputs = TestReflection::getValue($this->object, 'outputs');

		$this->assertEquals($outputs[1], $output);
	}

	/**
	 * Tests the error thrown by the PNTransition::addOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::addOutput
	 *
	 * @since   1.0
	 *
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAddOutputError()
	{
		$this->object->addOutput(new stdClass);
	}

	/**
	 * Check if the Transition is loaded.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::isLoaded
	 * @since   1.0
	 */
	public function testIsLoaded()
	{
		$this->assertFalse($this->object->isLoaded());

		// Add an input.
		TestReflection::setValue($this->object, 'inputs', array('test'));

		$this->assertFalse($this->object->isLoaded());

		// Add an output.
		TestReflection::setValue($this->object, 'outputs', array('test'));

		$this->assertTrue($this->object->isLoaded());
	}

	/**
	 * Verify if this Transition is Enabled.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::isEnabled
	 * @since   1.0
	 */
	public function testIsEnabled()
	{
		$this->assertTrue(false);
	}

	/**
	 * Execute (fire) the Transition (it supposes it is enabled).
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::execute
	 * @since   1.0
	 */
	public function testExecute()
	{
		$this->assertTrue(false);
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::accept
	 * @since   1.0
	 */
	public function testAccept()
	{
		$visitor = $this->getMock('PNBaseVisitor');

		$visitor->expects($this->once())
			->method('visitTransition')
			->with($this->object);

		$this->object->accept($visitor);
	}
}
