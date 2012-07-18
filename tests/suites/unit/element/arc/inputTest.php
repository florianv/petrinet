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

		// Set a random object.
		$obj = new stdClass;
		$caught = false;

		try
		{
			$this->object->setInput($obj);
		}
		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);
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

		// Set a random object.
		$obj = new stdClass;
		$caught = false;

		try
		{
			$this->object->setOutput($obj);
		}
		catch (Exception $e)
		{
			$caught = true;
		}

		$this->assertTrue($caught);
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArcInput::accept
	 * @todo
	 * @since   1.0
	 */
	public function testAccept()
	{

	}
}
