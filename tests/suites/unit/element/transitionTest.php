<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNElementTransition.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNElementTransitionTest extends TestCase
{
	/**
	 * @var    PNElementTransition  A PNElementTransition instance.
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

		$this->object = new PNElementTransition;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		// Test without param.
		$transition = new PNElementTransition;

		$this->assertNull(TestReflection::getValue($transition, 'guard'));
		$this->assertEmpty(TestReflection::getValue($transition, 'inputs'));
		$this->assertEmpty(TestReflection::getValue($transition, 'outputs'));

		// Test with params.
		$guard = new PNElementGuard;
		$inputs = array(new PNElementArcInput, new PNElementArcInput);
		$outputs = array(new PNElementArcOutput, new PNElementArcOutput);

		$transition = new PNElementTransition($guard, $inputs, $outputs);

		$this->assertEquals($guard, TestReflection::getValue($transition, 'guard'));
		$this->assertEquals($inputs, TestReflection::getValue($transition, 'inputs'));
		$this->assertEquals($outputs, TestReflection::getValue($transition, 'outputs'));
	}

	/**
	 * Add an input Arc to this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::addInput
	 * @since   1.0
	 */
	public function testAddInput()
	{
		$input = new PNElementArcInput;
		$this->object->addInput($input);
		$inputs = TestReflection::getValue($this->object, 'inputs');

		$this->assertEquals($inputs[0], $input);

		$input = new PNElementArcInput;
		$this->object->addInput($input);
		$inputs = TestReflection::getValue($this->object, 'inputs');
		$this->assertEquals($inputs[1], $input);
	}

	/**
	 * Tests the error thrown by the PNElementTransition::addInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::addInput
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
	 * @covers  PNElementTransition::getInputs
	 * @since   1.0
	 */
	public function testGetInputs()
	{
		$this->assertEmpty($this->object->getInputs());

		// Add two input arcs.
		$inputs = array(new PNElementArcInput, new PNElementArcInput);
		TestReflection::setValue($this->object, 'inputs', $inputs);

		$this->assertEquals($inputs, $this->object->getInputs());
	}

	/**
	 * Add an ouput Arc to this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::addOutput
	 * @since   1.0
	 */
	public function testAddOutput()
	{
		$output = new PNElementArcOutput;
		$this->object->addOutput($output);
		$outputs = TestReflection::getValue($this->object, 'outputs');

		$this->assertEquals($outputs[0], $output);

		$output = new PNElementArcOutput;
		$this->object->addOutput($output);
		$outputs = TestReflection::getValue($this->object, 'outputs');

		$this->assertEquals($outputs[1], $output);
	}

	/**
	 * Tests the error thrown by the PNElementTransition::addOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::addOutput
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
	 * @covers  PNElementTransition::getOutputs
	 * @since   1.0
	 */
	public function testGetOutputs()
	{
		$this->assertEmpty($this->object->getOutputs());

		// Add two output arcs.
		$outputs = array(new PNElementArcOutput, new PNElementArcOutput);
		TestReflection::setValue($this->object, 'outputs', $outputs);

		$this->assertEquals($outputs, $this->object->getOutputs());
	}

	/**
	 * Set a Guard for this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::setGuard
	 * @since   1.0
	 */
	public function testSetGuard()
	{
		$guard = new PNElementGuard;
		$this->object->setGuard($guard);

		$this->assertEquals($guard, TestReflection::getValue($this->object, 'guard'));
	}

	/**
	 * Tests the error thrown by the PNElementTransition::setGuard method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::setGuard
	 *
	 * @since   1.0
	 *
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetGuardException()
	{
		$this->object->setGuard(new stdClass);
	}

	/**
	 * Get the Guard of this Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::getGuard
	 * @since   1.0
	 */
	public function testGetGuard()
	{
		$this->assertNull($this->object->getGuard());

		$guard = new PNElementGuard;
		TestReflection::setValue($this->object, 'guard', $guard);

		$this->assertEquals($guard, $this->object->getGuard());
	}

	/**
	 * Check if this Transition is Guarded.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::isGuarded
	 * @since   1.0
	 */
	public function testIsGuarded()
	{
		$this->assertFalse($this->object->isGuarded());

		$guard = new PNElementGuard;
		TestReflection::setValue($this->object, 'guard', $guard);

		$this->assertTrue($this->object->isGuarded());
	}

	/**
	 * Verify if this Transition is Enabled.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::isEnabled
	 * @since   1.0
	 */
	public function testIsEnabled()
	{
		// Generate a guarded transition where the guard returns false.
		$var = new PNElementVariable('test', 'test');
		$op = new PNConditionComparisonEq;
		$guard = new PNElementGuard($op, $var, 8);

		$this->object->setGuard($guard);

		$this->assertFalse($this->object->isEnabled());

		// Generate a guarded transition where the guard returns true.
		$guard = new PNElementGuard($op, $var, 'test');
		$this->object->setGuard($guard);

		// PlaceBefore contains 0 tokens.
		$placeBefore = new PNElementPlace;
		$placeAfter = new PNElementPlace;

		$input = new PNElementArcInput;
		$input->setInput($placeBefore)->setOutput($this->object);

		$output = new PNElementArcOutput;
		$output->setInput($this->object, $placeAfter);

		$this->object->addInput($input)->addOutput($output);

		$this->assertFalse($this->object->isEnabled());

		// Add one token in placeBefore.
		$placeBefore->addToken(new stdClass);

		$this->assertTrue($this->object->isEnabled());
	}

	/**
	 * Execute (fire) the Transition (it supposes it is enabled).
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::execute
	 * @since   1.0
	 */
	public function testExecute()
	{
		// Generate a mini enabled Petri net transition.
		$placeBefore1 = new PNElementPlace;
		$placeBefore1->addToken(new stdClass);

		$placeBefore2 = new PNElementPlace;
		$placeBefore2->addToken(new stdClass);

		$placeAfter = new PNElementPlace;

		$input1 = new PNElementArcInput;
		$input1->setInput($placeBefore1)->setOutput($this->object);

		$input2 = new PNElementArcInput;
		$input2->setInput($placeBefore2)->setOutput($this->object);

		$output = new PNElementArcOutput;
		$output->setInput($this->object)->setOutput($placeAfter);

		TestReflection::setValue($this->object, 'inputs', array($input1, $input2));
		TestReflection::setValue($this->object, 'outputs', array($output));

		$this->object->execute();

		// Verify placeBefore1 and placeBefore2 contains no token.
		$this->assertEquals(0, $placeBefore1->getTokenCount());
		$this->assertEquals(0, $placeBefore2->getTokenCount());

		// And placeAfter contains one token.
		$this->assertEquals(1, $placeAfter->getTokenCount());

		// Try with a new one.
		$placeBefore1 = new PNElementPlace;

		// Add two tokens in this place.
		$placeBefore1->addToken(new stdClass)->addToken(new stdClass);

		$placeBefore2 = new PNElementPlace;
		$placeBefore2->addToken(new stdClass);

		$placeAfter = new PNElementPlace;

		$input1 = new PNElementArcInput;
		$input1->setInput($placeBefore1)->setOutput($this->object);

		$input2 = new PNElementArcInput;
		$input2->setInput($placeBefore2)->setOutput($this->object);

		$output = new PNElementArcOutput;
		$output->setInput($this->object)->setOutput($placeAfter);

		// Set the arc's weight to 2.
		$output->setWeight(2);

		TestReflection::setValue($this->object, 'inputs', array($input1, $input2));
		TestReflection::setValue($this->object, 'outputs', array($output));

		// Set the weight of the output arc to 2.
		$output->setWeight(2);

		$this->object->execute();

		// Verify placeBefore1 contains one token and placeBefore2 contains no token.
		$this->assertEquals(1, $placeBefore1->getTokenCount());
		$this->assertEquals(0, $placeBefore2->getTokenCount());

		// And placeAfter contains two tokens.
		$this->assertEquals(2, $placeAfter->getTokenCount());
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @covers  PNElementTransition::accept
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
