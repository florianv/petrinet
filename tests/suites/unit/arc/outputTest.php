<?php
/**
 * @package     Tests.Unit
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNArcOutput.
 *
 * @package     Tests.Unit
 * @subpackage  Arc
 * @since       1.0
 */
class PNArcOutputTest extends TestCase
{
	/**
	 * @var    PNArcOutput  A PNArcOutput instance.
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

		$this->object = new PNArcOutput;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNArcOutput::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$arc = new PNArcOutput;
		$this->assertNull(TestReflection::getValue($arc, 'input'));
		$this->assertNull(TestReflection::getValue($arc, 'output'));
		$this->assertNull(TestReflection::getValue($arc, 'expression'));
		$this->assertInstanceOf('PNTypeManager', TestReflection::getValue($arc, 'typeManager'));

		$transition = new PNTransition;
		$place = new PNPlace;
		$expression = $this->getMockForAbstractClass('PNArcExpression');
		$arc = new PNArcOutput($transition, $place, $expression);

		$this->assertEquals(TestReflection::getValue($arc, 'input'), $transition);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $place);
		$this->assertEquals(TestReflection::getValue($arc, 'expression'), $expression);
	}

	/**
	 * Set the input Transition of this Arc.
	 *
	 * @return  void
	 *
	 * @cover   PNArcOutput::setInput
	 * @since   1.0
	 */
	public function testSetInput()
	{
		// Set an input transition.
		$input = new PNTransition;
		$this->object->setInput($input);
		$in = TestReflection::getValue($this->object, 'input');

		$this->assertEquals($in, $input);
	}

	/**
	 * Tests the error thrown by the PNArcOutput::setInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNArcOutput::setInput
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetInputException()
	{
		$this->object->setInput(new stdClass);
	}

	/**
	 * Set the output Place of this Arc.
	 *
	 * @return  void
	 *
	 * @cover   PNArcOutput::setOutput
	 * @since   1.0
	 */
	public function testSetOutput()
	{
		// Set an output place.
		$output = new PNPlace;
		$this->object->setOutput($output);
		$out = TestReflection::getValue($this->object, 'output');

		$this->assertEquals($out, $output);
	}

	/**
	 * Tests the error thrown by the PNArcOutput::setOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNArcOutput::setOutput
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetOutputError()
	{
		$this->object->setOutput(new stdClass);
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @cover   PNArcOutput::accept
	 * @since   1.0
	 */
	public function testAccept()
	{
		$visitor = $this->getMock('PNBaseVisitor');

		$visitor->expects($this->once())
			->method('visitOutputArc')
			->with($this->object);

		$this->object->accept($visitor);
	}
}
