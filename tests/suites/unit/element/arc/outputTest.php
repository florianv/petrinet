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
	 * @cover   PNElementArcOutput::accept
	 * @todo
	 * @since   1.0
	 */
	public function testAccept()
	{

	}
}
