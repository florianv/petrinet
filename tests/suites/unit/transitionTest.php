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
		// Test with a non loaded transition.
		$this->assertFalse($this->object->isLoaded());

		// Non colored mode.
		$mockedTransition = $this->getMock('PNTransition', array('doIsEnabledBasic'));

		// Add an input and output.
		TestReflection::setValue($mockedTransition, 'inputs', array('test'));
		TestReflection::setValue($mockedTransition, 'outputs', array('test'));

		$mockedTransition->expects($this->once())
			->method('doIsEnabledBasic');

		$mockedTransition->isEnabled();

		// Add a color set => colored mode.
		$mockedTransition = $this->getMock('PNTransition', array('doIsEnabledColored'));

		// Add an input and output.
		TestReflection::setValue($mockedTransition, 'inputs', array('test'));
		TestReflection::setValue($mockedTransition, 'outputs', array('test'));
		TestReflection::setValue($mockedTransition, 'colorSet', new PNColorSet);

		$mockedTransition->expects($this->once())
			->method('doIsEnabledColored');

		$mockedTransition->isEnabled();
	}

	/**
	 * Check if the Transition is enabled for basic (not colored Petri Nets).
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::doIsEnabledBasic
	 * @since   1.0
	 */
	public function testDoIsEnabledBasic()
	{
		// @todo
		$this->assertTrue(false);
	}

	/**
	 * Check if the Transition is enabled for color Petri Nets.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::doIsEnabledColored
	 * @expectedException  RuntimeException
	 *
	 * @since   1.0
	 */
	public function testDoIsEnabledColored()
	{
		TestReflection::invoke($this->object, 'doIsEnabledColored');
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
		// Non colored mode.
		$mockedTransition = $this->getMock('PNTransition', array('doExecuteBasic', 'doExecute'));

		// Add an input and output.
		TestReflection::setValue($mockedTransition, 'inputs', array('test'));
		TestReflection::setValue($mockedTransition, 'outputs', array('test'));

		$mockedTransition->expects($this->once())
			->method('doExecuteBasic');

		$mockedTransition->expects($this->once())
			->method('doExecute');

		$mockedTransition->execute();

		// Add a color set => colored mode.
		$mockedTransition = $this->getMock('PNTransition', array('doExecuteColored', 'doExecute'));

		// Add an input and output.
		TestReflection::setValue($mockedTransition, 'inputs', array('test'));
		TestReflection::setValue($mockedTransition, 'outputs', array('test'));
		TestReflection::setValue($mockedTransition, 'colorSet', new PNColorSet);

		$mockedTransition->expects($this->once())
			->method('doExecuteColored');

		$mockedTransition->expects($this->once())
			->method('doExecute');

		$mockedTransition->execute();
	}

	/**
	 * Fire the Transition in normal mode.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::doExecuteBasic
	 * @since   1.0
	 */
	public function testDoExecuteBasic()
	{
		// @†odo
		$this->assertFalse(true);
	}

	/**
	 * Fire the Transition in colored mode.
	 *
	 * @return  void
	 *
	 * @expectedException  RuntimeException
	 *
	 * @covers  PNTransition::doExecuteColored
	 *
	 * @since   1.0
	 */
	public function testDoExecuteColored()
	{
		TestReflection::invoke($this->object, 'doIsEnabledColored');
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
