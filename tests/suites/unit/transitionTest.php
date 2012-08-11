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
		$this->assertFalse($this->object->isEnabled());

		/**
		 * Test with an enabled transition and mocked input arc expressions,
		 * returning data values of types being a subset of the transition color set.
		 */
		// Create two places with a random color set.
		$colorSet1 = new PNColorSet(array('integer', 'float'));
		$colorSet2 = new PNColorSet(array('boolean'));

		$place1 = new PNPlace($colorSet1);
		$place2 = new PNPlace($colorSet2);

		// Add tokens in these places for initial marking.
		$color1 = new PNColor(array(2, 2.2));
		$color2 = new PNColor(array(true));

		$token1 = new PNToken($color1);
		$token2 = new PNToken($color2);

		$place1->addToken($token1);
		$place2->addToken($token2);

		// Create the transition.
		$transitionColorSet = new PNColorSet(array('integer', 'float', 'boolean'));
		$transition = new PNTransition($transitionColorSet);

		// Create two mocked arc expressions.
		$expression1 = $this->getMockForAbstractClass('PNArcExpression');
		$expression1->expects($this->any())
			->method('execute')
			->will($this->returnValue(array(2, 2.2)));

		$expression2 = $this->getMockForAbstractClass('PNArcExpression');
		$expression2->expects($this->any())
			->method('execute')
			->will($this->returnValue(array(true)));

		// Create the input arc, and add the expression on its.
		$inputArc1 = new PNArcInput($place1, $transition, $expression1);
		$inputArc2 = new PNArcInput($place2, $transition, $expression2);

		$transition->addInput($inputArc1)
			->addInput($inputArc2);

		$place1->addOutput($inputArc1);
		$place2->addOutput($inputArc2);

		// Add a random output arc.
		$transition->addOutput(new PNArcOutput);

		$this->assertTrue($transition->isEnabled());

		/**
		 * Test with a non enabled transition : wrong input arc expressions.
		 */
		// Create two places with a random color set.
		$colorSet1 = new PNColorSet(array('integer', 'float'));
		$colorSet2 = new PNColorSet(array('boolean'));

		$place1 = new PNPlace($colorSet1);
		$place2 = new PNPlace($colorSet2);

		// Add tokens in these places for initial marking.
		$color1 = new PNColor(array(2, 2.2));
		$color2 = new PNColor(array(true));

		$token1 = new PNToken($color1);
		$token2 = new PNToken($color2);

		$place1->addToken($token1);
		$place2->addToken($token2);

		// Create the transition.
		$transitionColorSet = new PNColorSet(array('integer', 'float', 'boolean'));
		$transition = new PNTransition($transitionColorSet);

		// Wrong input arc expression.
		$expression1 = $this->getMockForAbstractClass('PNArcExpression');
		$expression1->expects($this->any())
			->method('execute')
			->will($this->returnValue(array(2, 5)));

		$expression2 = $this->getMockForAbstractClass('PNArcExpression');
		$expression2->expects($this->any())
			->method('execute')
			->will($this->returnValue(array(true)));

		// Create the input arc, and add the expression on its.
		$inputArc1 = new PNArcInput($place1, $transition, $expression1);
		$inputArc2 = new PNArcInput($place2, $transition, $expression2);

		$transition->addInput($inputArc1)
			->addInput($inputArc2);

		$place1->addOutput($inputArc1);
		$place2->addOutput($inputArc2);

		// Add a random output arc.
		$transition->addOutput(new PNArcOutput);

		$this->assertFalse($transition->isEnabled());

		/**
		 * Test with an enabled transition with no arc expressions.
		 */
		$colorSet1 = new PNColorSet(array('integer', 'array'));
		$colorSet2 = new PNColorSet(array('boolean'));

		$place1 = new PNPlace($colorSet1);
		$place2 = new PNPlace($colorSet2);

		// Add tokens in these places for initial marking.
		$color1 = new PNColor(array(2, array(3)));
		$color2 = new PNColor(array(true));

		$token1 = new PNToken($color1);
		$token2 = new PNToken($color2);

		$place1->addToken($token1);
		$place2->addToken($token2);

		// Create the transition.
		$transitionColorSet = new PNColorSet(array('integer', 'array', 'boolean'));
		$transition = new PNTransition($transitionColorSet);

		// Create the input arc, and add the expression on its.
		$inputArc1 = new PNArcInput($place1, $transition);
		$inputArc2 = new PNArcInput($place2, $transition);

		$transition->addInput($inputArc1)
			->addInput($inputArc2);

		$place1->addOutput($inputArc1);
		$place2->addOutput($inputArc2);

		// Add a random output arc.
		$transition->addOutput(new PNArcOutput);

		$this->assertTrue($transition->isEnabled());

		/**
		 * Test with non enabled transition : the input places color sets aren't a subset of the
		 * transition color set.
		 */
		$colorSet1 = new PNColorSet(array('integer', 'float'));
		$colorSet2 = new PNColorSet(array('boolean'));

		$place1 = new PNPlace($colorSet1);
		$place2 = new PNPlace($colorSet2);

		// Add tokens in these places for initial marking.
		$color1 = new PNColor(array(2, 2.2));
		$color2 = new PNColor(array(true));

		$token1 = new PNToken($color1);
		$token2 = new PNToken($color2);

		$place1->addToken($token1);
		$place2->addToken($token2);

		// Create the transition.
		$transitionColorSet = new PNColorSet(array('integer', 'array', 'boolean'));
		$transition = new PNTransition($transitionColorSet);

		// Create the input arcs, and link the petri net.
		$inputArc1 = new PNArcInput($place1, $transition);
		$inputArc2 = new PNArcInput($place2, $transition);

		$transition->addInput($inputArc1)
			->addInput($inputArc2);

		$place1->addOutput($inputArc1);
		$place2->addOutput($inputArc2);

		// Add a random output arc.
		$transition->addOutput(new PNArcOutput);

		$this->assertFalse($transition->isEnabled());

		/**
		 * Test with non enabled transition : one token is missing in place2
		 */
		$colorSet1 = new PNColorSet(array('integer', 'float'));
		$colorSet2 = new PNColorSet(array('boolean'));

		$place1 = new PNPlace($colorSet1);
		$place2 = new PNPlace($colorSet2);

		// Add tokens in the place1 for initial marking.
		$color1 = new PNColor(array(2, 2.2));
		$token1 = new PNToken($color1);

		$place1->addToken($token1);

		// Create the transition.
		$transitionColorSet = new PNColorSet(array('integer', 'array', 'boolean'));
		$transition = new PNTransition($transitionColorSet);

		// Create the input arcs, and link the petri net.
		$inputArc1 = new PNArcInput($place1, $transition);
		$inputArc2 = new PNArcInput($place2, $transition);

		$transition->addInput($inputArc1)
			->addInput($inputArc2);

		$place1->addOutput($inputArc1);
		$place2->addOutput($inputArc2);

		// Add a random output arc.
		$transition->addOutput(new PNArcOutput);

		$this->assertFalse($transition->isEnabled());

		/**
		 * Test with an enabled transition : the arc expression evaluates to a colour in the
		 * transition color set, but the input places color set doesn't match the transition color set.
		 */
		// Create two places with a random color set.
		$colorSet1 = new PNColorSet(array('integer'));
		$colorSet2 = new PNColorSet(array('boolean', 'float'));

		$place1 = new PNPlace($colorSet1);
		$place2 = new PNPlace($colorSet2);

		// Add tokens in these places for initial marking.
		$color1 = new PNColor(array(2));
		$color2 = new PNColor(array(true, 2.2));

		$token1 = new PNToken($color1);
		$token2 = new PNToken($color2);

		$place1->addToken($token1);
		$place2->addToken($token2);

		// Create the transition.
		$transitionColorSet = new PNColorSet(array('array', 'string'));
		$transition = new PNTransition($transitionColorSet);

		// Create the arc expressions.
		$expression1 = $this->getMockForAbstractClass('PNArcExpression');
		$expression1->expects($this->any())
			->method('execute')
			->will($this->returnValue(array(array(8))));

		$expression2 = $this->getMockForAbstractClass('PNArcExpression');
		$expression2->expects($this->any())
			->method('execute')
			->will($this->returnValue(array('test')));

		// Create the input arc, and add the expression on its.
		$inputArc1 = new PNArcInput($place1, $transition, $expression1);
		$inputArc2 = new PNArcInput($place2, $transition, $expression2);

		$transition->addInput($inputArc1)
			->addInput($inputArc2);

		$place1->addOutput($inputArc1);
		$place2->addOutput($inputArc2);

		// Add a random output arc.
		$transition->addOutput(new PNArcOutput);

		$this->assertTrue($transition->isEnabled());
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
