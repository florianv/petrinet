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
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		// Test without param.
		$transition = new PNTransition;

		$this->assertInstanceOf('PNColorSet', TestReflection::getValue($transition, 'colorSet'));
		$this->assertEmpty(TestReflection::getValue($transition, 'inputs'));
		$this->assertEmpty(TestReflection::getValue($transition, 'outputs'));

		// Test with params.
		$colorSet = new PNColorSet;
		$inputs = array(new PNArcInput, new PNArcInput);
		$outputs = array(new PNArcOutput, new PNArcOutput);

		$transition = new PNTransition($colorSet, $inputs, $outputs);

		$this->assertEquals($colorSet, TestReflection::getValue($transition, 'colorSet'));
		$this->assertEquals($inputs, TestReflection::getValue($transition, 'inputs'));
		$this->assertEquals($outputs, TestReflection::getValue($transition, 'outputs'));
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
	public function testAddInputException()
	{
		$this->object->addInput(new stdClass);
	}

	/**
	 * Get the input Arcs of this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::getInputs
	 * @since   1.0
	 */
	public function testGetInputs()
	{
		$this->assertEmpty($this->object->getInputs());

		// Add two input arcs.
		$inputs = array(new PNArcInput, new PNArcInput);
		TestReflection::setValue($this->object, 'inputs', $inputs);

		$this->assertEquals($inputs, $this->object->getInputs());
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
	public function testAddOutputException()
	{
		$this->object->addOutput(new stdClass);
	}

	/**
	 * Get the output Arcs of this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNTransition::getOutputs
	 * @since   1.0
	 */
	public function testGetOutputs()
	{
		$this->assertEmpty($this->object->getOutputs());

		// Add two output arcs.
		$outputs = array(new PNArcOutput, new PNArcOutput);
		TestReflection::setValue($this->object, 'outputs', $outputs);

		$this->assertEquals($outputs, $this->object->getOutputs());
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
