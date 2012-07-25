<?php
/**
 * @package     Tests.Unit
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNElementArcOutput.
 *
 * @package     Tests.Unit
 * @subpackage  Arc
 * @since       1.0
 */
class PNElementArcOutputTest extends TestCase
{
	/**
	 * @var    PNElementArcOutput  A PNElementArcOutput instance.
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

		$this->object = new PNElementArcOutput;
	}

	/**
	 * Set the input Transition of this Arc.
	 *
	 * @return  void
	 *
	 * @cover   PNElementArcOutput::setInput
	 * @since   1.0
	 */
	public function testSetInput()
	{
		// Set an input transition.
		$input = new PNElementTransition;
		$this->object->setInput($input);
		$in = TestReflection::getValue($this->object, 'input');

		$this->assertEquals($in, $input);
	}

	/**
	 * Tests the error thrown by the PNElementArcOutput::setInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcOutput::setInput
	 *
	 * @since   1.0
	 *
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
	 * @cover   PNElementArcOutput::setOutput
	 * @since   1.0
	 */
	public function testSetOutput()
	{
		// Set an output place.
		$output = new PNElementPlace;
		$this->object->setOutput($output);
		$out = TestReflection::getValue($this->object, 'output');

		$this->assertEquals($out, $output);
	}

	/**
	 * Tests the error thrown by the PNElementArcOutput::setOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcOutput::setOutput
	 *
	 * @since   1.0
	 *
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
	 * @cover   PNElementArcOutput::accept
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
