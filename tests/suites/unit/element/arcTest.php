<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test Class for PNElementArc.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNElementArcTest extends TestCase
{
	/**
	 * @var    PNElementArc  A PNElementArc mock.
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

		$this->object = $this->getMockForAbstractClass('PNElementArc');
	}

	/**
	 * Get the input Place or Transition of this Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNElementArc::getInput
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
	 * @covers  PNElementArc::getOutput
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
	 * @covers  PNElementArc::setWeight
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
	 * @covers  PNElementArc::getWeight
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
}
