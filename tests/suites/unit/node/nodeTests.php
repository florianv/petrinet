<?php
/**
 * @package     Tests.Unit
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNNode.
 *
 * @package     Tests.Unit
 * @subpackage  Petrinet
 * @since       1.0
 */
class PNNodeTest extends TestCase
{
	/**
	 * @var    PNNode  A PNNode mock.
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

		$this->object = $this->getMockForAbstractClass('PNNode');
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		// Test default values.
		$this->assertNull(TestReflection::getValue($this->object, 'colorSet'));
		$this->assertEmpty(TestReflection::getValue($this->object, 'inputs'));
		$this->assertEmpty(TestReflection::getValue($this->object, 'outputs'));

		// Test with params.
		$colorSet = new PNColorSet(array('integer'));
		$inputs = array(new PNArc, new PNArc);
		$outputs = array(new PNArc, new PNArc);

		$mock = $this->getMockForAbstractClass('PNNode', array(), '', true, true, true, array('setInputs', 'setOutputs'));

		$mock->expects($this->once())
			->method('setInputs');

		$mock->expects($this->once())
			->method('setOutputs');

		$mock->__construct($colorSet, $inputs, $outputs);
	}

	/**
	 * Add an input Arc to this Node.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::addInput
	 * @since   1.0
	 */
	public function testAddInput()
	{
		// Add an input (output) arc to this place.
		$arc = new PNArc;
		$this->object->addInput($arc);
		$input = TestReflection::getValue($this->object, 'inputs');

		$this->assertEquals($input[0], $arc);

		// Add a new one
		$this->object->addInput($arc);
		$input = TestReflection::getValue($this->object, 'inputs');

		$this->assertCount(2, $input);
		$this->assertEquals($input[1], $arc);
	}

	/**
	 * Get the input Arcs of this Node.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::getInputs
	 * @since   1.0
	 */
	public function testGetInputs()
	{
		$this->assertEmpty($this->object->getInputs());

		// Add an input.
		TestReflection::setValue($this->object, 'inputs', true);
		$this->assertTrue($this->object->getInputs());
	}

	/**
	 * Set the input Arcs of this Node.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::setInputs
	 * @since   1.0
	 */
	public function testSetInputs()
	{
		$mock = $this->getMockForAbstractClass('PNNode', array(), '', true, true, true, array('addInput'));

		$mock->expects($this->exactly(3))
			->method('addInput');

		$mock->setInputs(array(new PNArc, new PNArc, new PNArc));
	}

	/**
	 * Check if the Node has at least one input arc.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::hasInput
	 * @since   1.0
	 */
	public function testHasInput()
	{
		$this->assertFalse($this->object->hasInput());

		TestReflection::setValue($this->object, 'inputs', array('test'));
		$this->assertTrue($this->object->hasInput());
	}

	/**
	 * Add an output Arc to this Node.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::addOutput
	 * @since   1.0
	 */
	public function testAddOutput()
	{
		// Add an output arc to this place.
		$arc = new PNArc;
		$this->object->addOutput($arc);
		$output = TestReflection::getValue($this->object, 'outputs');

		$this->assertEquals($output[0], $arc);

		// Add a new one
		$this->object->addOutput($arc);
		$output = TestReflection::getValue($this->object, 'outputs');

		$this->assertCount(2, $output);
		$this->assertEquals($output[1], $arc);
	}

	/**
	 * Get the output Arc of this Node.
	 *
	 * @return  array  An array of output Arc objects.
	 *
	 * @covers  PNNode::getOutputs
	 * @since   1.0
	 */
	public function testGetOutputs()
	{
		$this->assertEmpty($this->object->getOutputs());

		// Add an output.
		TestReflection::setValue($this->object, 'outputs', true);
		$this->assertTrue($this->object->getOutputs());
	}

	/**
	 * Set the output Arcs of this Node.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::setOutputs
	 * @since   1.0
	 */
	public function testSetOutputs()
	{
		$mock = $this->getMockForAbstractClass('PNNode', array(), '', true, true, true, array('addOutput'));

		$mock->expects($this->exactly(3))
			->method('addOutput');

		$mock->setOutputs(array(new PNArc, new PNArc, new PNArc));
	}

	/**
	 * Check if the Node has at least one output arc.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::hasOutput
	 * @since   1.0
	 */
	public function testHasOutput()
	{
		$this->assertFalse($this->object->hasOutput());

		TestReflection::setValue($this->object, 'outputs', array('test'));
		$this->assertTrue($this->object->hasOutput());
	}

	/**
	 * Assert the Node is loaded.
	 *
	 * @return  void
	 *
	 * @expectedException  RuntimeException
	 *
	 * @covers  PNNode::assertIsLoaded
	 * @since   1.0
	 */
	public function testAssertIsLoadedException()
	{
		$this->object->expects($this->once())
			->method('isLoaded')
			->will($this->returnValue(false));

		$this->object->assertIsLoaded();
	}

	/**
	 * Assert the Node is loaded.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::assertIsLoaded
	 * @since   1.0
	 */
	public function testAssertIsLoaded()
	{
		$this->object->expects($this->once())
			->method('isLoaded')
			->will($this->returnValue(true));

		$this->assertNull($this->object->assertIsLoaded());
	}

	/**
	 * Set the color set of this Node.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::setColorSet
	 * @since   1.0
	 */
	public function testSetColorSet()
	{
		$set = new PNColorSet(array('integer', 'double'));
		$this->object->setColorSet($set);

		$this->assertEquals(TestReflection::getValue($this->object, 'colorSet'), $set);
	}

	/**
	 * Get the color set of this Node.
	 *
	 * @return  void.
	 *
	 * @covers  PNNode::getColorSet
	 * @since   1.0
	 */
	public function testGetColorSet()
	{
		TestReflection::setValue($this->object, 'colorSet', true);
		$this->assertTrue($this->object->getColorSet());
	}

	/**
	 * Check if we are in colored mode.
	 *
	 * @return  void
	 *
	 * @covers  PNNode::isColoredMode
	 * @since   1.0
	 */
	public function testIsColoredMode()
	{
		$this->assertFalse($this->object->isColoredMode());

		// Set a color set.
		TestReflection::setValue($this->object, 'colorSet', new PNColorSet);
		$this->assertTrue($this->object->isColoredMode());
	}
}
