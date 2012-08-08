<?php
/**
 * @package     Tests.Unit
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNArcInput.
 *
 * @package     Tests.Unit
 * @subpackage  Arc
 * @since       1.0
 */
class PNArcInputTest extends TestCase
{
	/**
	 * @var    PNArcInput  A PNArcInput instance.
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

		$this->object = new PNArcInput;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$arc = new PNArcInput;
		$this->assertNull(TestReflection::getValue($arc, 'input'));
		$this->assertNull(TestReflection::getValue($arc, 'output'));
		$this->assertNull(TestReflection::getValue($arc, 'expression'));

		$place = new PNPlace;
		$transition = new PNTransition;
		$expression = $this->getMockForAbstractClass('PNArcExpression');
		$arc = new PNArcInput($place, $transition, $expression);

		$this->assertEquals(TestReflection::getValue($arc, 'input'), $place);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $transition);
		$this->assertEquals(TestReflection::getValue($arc, 'expression'), $expression);
	}

	/**
	 * Set the input Place of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::setInput
	 * @since   1.0
	 */
	public function testSetInput()
	{
		// Set an input place.
		$input = new PNPlace;
		$this->object->setInput($input);
		$in = TestReflection::getValue($this->object, 'input');

		$this->assertEquals($in, $input);
	}

	/**
	 * Tests the error thrown by the PNArcInput::setInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::setInput
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetInputException()
	{
		$this->object->setInput(new stdClass);
	}

	/**
	 * Set the output Transition of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::setOutput
	 * @since   1.0
	 */
	public function testSetOutput()
	{
		// Set an output transition.
		$output = new PNTransition;
		$this->object->setOutput($output);
		$out = TestReflection::getValue($this->object, 'output');

		$this->assertEquals($out, $output);
	}

	/**
	 * Tests the error thrown by the PNArcInput::setOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::setOutput
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testSetOutputException()
	{
		$this->object->setOutput(new stdClass);
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @covers  PNArcInput::accept
	 * @since   1.0
	 */
	public function testAccept()
	{
		$visitor = $this->getMock('PNBaseVisitor');

		$visitor->expects($this->once())
			->method('visitInputArc')
			->with($this->object);

		$this->object->accept($visitor);
	}
}
