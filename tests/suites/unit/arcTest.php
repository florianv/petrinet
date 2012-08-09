<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test Class for PNArc.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNArcTest extends TestCase
{
	/**
	 * @var    PNArc  A PNArc mock.
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

		$this->object = $this->getMockForAbstractClass('PNArc');
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::getInput
	 * @since   1.0
	 */
	public function test__construct()
	{
		$this->assertNull(TestReflection::getValue($this->object, 'expression'));

		$expression = $this->getMockForAbstractClass('PNArcExpression');
		$arc = $this->getMockForAbstractClass('PNArc', array($expression));

		$this->assertEquals(TestReflection::getValue($arc, 'expression'), $expression);
	}

	/**
	 * Get the input Place or Transition of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::getInput
	 * @since   1.0
	 */
	public function testGetInput()
	{
		// Assert the input is empty.
		$input = $this->object->getInput();
		$this->assertEmpty($input);

		// Add an input.
		TestReflection::setValue($this->object, 'input', true);
		$this->assertTrue(TestReflection::getValue($this->object, 'input'));
	}

	/**
	 * Get the output Place or Transition of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::getOutput
	 * @since   1.0
	 */
	public function testGetOutput()
	{
		// Assert the output is empty.
		$output = $this->object->getOutput();
		$this->assertEmpty($output);

		// Add an output.
		TestReflection::setValue($this->object, 'output', true);
		$this->assertTrue(TestReflection::getValue($this->object, 'output'));
	}

	/**
	 * Set the weight of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::setWeight
	 * @since   1.0
	 */
	public function testSetWeight()
	{
		$this->object->setWeight(8);
		$weight = TestReflection::getValue($this->object, 'weight');
		$this->assertEquals(8, $weight);
	}

	/**
	 * Get the weight of this Arc.
	 *
	 * @return   void
	 *
	 * @covers  PNArc::getWeight
	 * @since   1.0
	 */
	public function testGetWeight()
	{
		// Test default weight.
		$this->assertEquals(1, $this->object->getWeight());

		// Change the weight.
		TestReflection::setValue($this->object, 'weight', 8);
		$this->assertEquals(8, $this->object->getWeight());
	}

	/**
	 * Check if the arc expression is valid.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::doValidateExpression
	 * @since   1.0
	 */
	public function testDoValidateExpression()
	{
		// Create a place.
		$colorSet = new PNColorSet(array('integer', 'float', 'array'));
		$place = new PNPlace(new PNTokenSet, $colorSet);
		TestReflection::setValue($this->object, 'input', $place);

		// Create a transition.
		$colorSet = new PNColorSet(array('integer', 'float', 'array'));
		$transition = new PNTransition($colorSet);
		TestReflection::setValue($this->object, 'output', $transition);

		// No expression set.
		$this->assertFalse(TestReflection::invoke($this->object, 'doValidateExpression', $place, $transition));

		// Mock the expression.
		$expression1 = $this->getMockForAbstractClass('PNArcExpression', array(array('integer', 'float', 'array')));
		$expression1->expects($this->once())
			->method('execute')
			->will($this->returnValue(array(8, 8.2, array())));

		TestReflection::setValue($this->object, 'expression', $expression1);

		$this->assertTrue(TestReflection::invoke($this->object, 'doValidateExpression', $place, $transition));

		// Test a sub-set of the transition color set.
		$expression2 = $this->getMockForAbstractClass('PNArcExpression', array(array('integer', 'float', 'array')));
		$expression2->expects($this->once())
			->method('execute')
			->will($this->returnValue(array(8, 8.2)));

		TestReflection::setValue($this->object, 'expression', $expression2);

		$this->assertTrue(TestReflection::invoke($this->object, 'doValidateExpression', $place, $transition));

		// Test with non matching transition color set return values types.
		$expression3 = $this->getMockForAbstractClass('PNArcExpression', array(array('integer', 'float', 'array')));
		$expression3->expects($this->once())
			->method('execute')
			->will($this->returnValue(array(8, 8.2, 3)));

		TestReflection::setValue($this->object, 'expression', $expression3);

		$this->assertFalse(TestReflection::invoke($this->object, 'doValidateExpression', $place, $transition));

		// Test with non matching expression arguments.
		$expression4 = $this->getMockForAbstractClass('PNArcExpression', array(array('float', 'float', 'array')));
		TestReflection::setValue($this->object, 'expression', $expression4);
		$this->assertFalse(TestReflection::invoke($this->object, 'doValidateExpression', $place, $transition));
	}

	/**
	 * Check if the arc has an expression attached to it.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::hasExpression
	 * @since   1.0
	 */
	public function testHasExpression()
	{
		$this->assertFalse($this->object->hasExpression());

		$expression = $this->getMockForAbstractClass('PNArcExpression');
		TestReflection::setValue($this->object, 'expression', $expression);

		$this->assertTrue($this->object->hasExpression());
	}

	/**
	 * Set the arc expression.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::setExpression
	 * @since   1.0
	 */
	public function testSetExpression()
	{
		$ex = $this->getMockForAbstractClass('PNArcExpression');

		$this->object->setExpression($ex);

		$this->assertEquals($ex, TestReflection::getValue($this->object, 'expression'));
	}

	/**
	 * Get the arc expression.
	 *
	 * @return  void
	 *
	 * @covers  PNArc::getExpression
	 * @since   1.0
	 */
	public function testGetExpression()
	{
		TestReflection::setValue($this->object, 'expression', true);
		$this->assertTrue($this->object->getExpression());
	}
}
