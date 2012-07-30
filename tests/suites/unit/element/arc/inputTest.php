<?php
/**
 * @package     Tests.Unit
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNElementArcInput.
 *
 * @package     Tests.Unit
 * @subpackage  Arc
 * @since       1.0
 */
class PNElementArcInputTest extends TestCase
{
	/**
	 * @var    PNElementArcInput  A PNElementArcInput instance.
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

		$this->object = new PNElementArcInput;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcInput::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$arc = new PNElementArcInput;
		$this->assertNull(TestReflection::getValue($arc, 'input'));
		$this->assertNull(TestReflection::getValue($arc, 'output'));

		$place = new PNElementPlace;
		$transition = new PNElementTransition;
		$arc = new PNElementArcInput($place, $transition);

		$this->assertEquals(TestReflection::getValue($arc, 'input'), $place);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $transition);
	}

	/**
	 * Set the input Place of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcInput::setInput
	 * @since   1.0
	 */
	public function testSetInput()
	{
		// Set an input place.
		$input = new PNElementPlace;
		$this->object->setInput($input);
		$in = TestReflection::getValue($this->object, 'input');

		$this->assertEquals($in, $input);
	}

	/**
	 * Tests the error thrown by the PNElementArcInput::setInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcInput::setInput
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
	 * @covers  PNElementArcInput::setOutput
	 * @since   1.0
	 */
	public function testSetOutput()
	{
		// Set an output transition.
		$output = new PNElementTransition;
		$this->object->setOutput($output);
		$out = TestReflection::getValue($this->object, 'output');

		$this->assertEquals($out, $output);
	}

	/**
	 * Tests the error thrown by the PNElementArcInput::setOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcInput::setOutput
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
	 * @covers  PNElementArcInput::accept
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
