<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNPlace.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNPlaceTest extends TestCase
{
	/**
	 * @var    PNPlace  A PNPlace instance.
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

		$this->object = new PNPlace;

		// Mock the token set.
		$setMock = $this->getMock('PNSet');
		TestReflection::setValue($this->object, 'tokenSet', $setMock);
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		// Test without param.
		$place = new PNPlace;

		$this->assertInstanceOf('PNSet', TestReflection::getValue($place, 'tokenSet'));
		$this->assertEmpty(TestReflection::getValue($place, 'inputs'));
		$this->assertEmpty(TestReflection::getValue($place, 'outputs'));

		// Test with params.
		$set = new PNSet;
		$inputs = array(new PNArcOutput, new PNArcOutput);
		$outputs = array(new PNArcInput, new PNArcInput);

		$place = new PNPlace($set, $inputs, $outputs);

		$this->assertEquals($set, TestReflection::getValue($place, 'tokenSet'));
		$this->assertEquals($inputs, TestReflection::getValue($place, 'inputs'));
		$this->assertEquals($outputs, TestReflection::getValue($place, 'outputs'));
	}

	/**
	 * Add an input Arc to this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addInput
	 * @since   1.0
	 */
	public function testAddInput()
	{
		// Add an input (output) arc to this place.
		$arc = new PNArcOutput;
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
	 * Tests the error thrown by the PNPlace::addInput method.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addInput
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAddInputException()
	{
		$this->object->addInput(new stdClass);
	}

	/**
	 * Get the input Arcs of this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::getInputs
	 * @since   1.0
	 */
	public function testGetInputs()
	{
		// Assert the default input is empty.
		$inputs = $this->object->getInputs();
		$this->assertEmpty($inputs);

		// Add two elements.
		$array1 = array(8, 3);

		TestReflection::setValue($this->object, 'inputs', $array1);
		$inputs = $this->object->getInputs();

		$this->assertCount(2, $inputs);
		$this->assertEquals($inputs[0], 8);
		$this->assertEquals($inputs[1], 3);
	}

	/**
	 * Add an output Arc to this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addOutput
	 * @since   1.0
	 */
	public function testAddOutput()
	{
		// Add an output (input) arc to this place.
		$arc = new PNArcInput;
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
	 * Tests the exception thrown by the PNPlace::addOutput method.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addOutput
	 * @since   1.0
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testAddOutputException()
	{
		$this->object->addOutput(new stdClass);
	}

	/**
	 * Get the output Arc of this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::getOutputs
	 * @since   1.0
	 */
	public function testGetOutputs()
	{
		// Assert the default output is empty.
		$inputs = $this->object->getOutputs();
		$this->assertEmpty($inputs);

		// Add two elements.
		$array1 = array(8, 3);

		TestReflection::setValue($this->object, 'outputs', $array1);
		$outputs = $this->object->getOutputs();

		$this->assertCount(2, $outputs);
		$this->assertEquals($outputs[0], 8);
		$this->assertEquals($outputs[1], 3);
	}

	/**
	 * Add a Token in this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addToken
	 * @since   1.0
	 */
	public function testAddToken()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('add');

		$this->object->addToken(new stdClass);
	}

	/**
	 * Add multiple Tokens in this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addTokens
	 * @since   1.0
	 */
	public function testAddTokens()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('addMultiple');

		$this->object->addTokens(array());
	}

	/**
	 * Remove a Token from this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::removeToken
	 * @since   1.0
	 */
	public function testRemoveToken()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('remove');

		$this->object->removeToken(new stdClass);
	}

	/**
	 * Remove all the Tokens from this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::clearTokens
	 * @since   1.0
	 */
	public function testClearTokens()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('clear');

		$this->object->clearTokens();
	}

	/**
	 * Get the Tokens in this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::getTokens
	 * @since   1.0
	 */
	public function testGetTokens()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('getElements');

		$this->object->getTokens();
	}

	/**
	 * Get the number of tokens in this place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::getTokenCount
	 * @since   1.0
	 */
	public function testGetTokenCount()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('count');

		$this->object->getTokenCount();
	}

	/**
	 * Check if the place is a Start Place.
	 * It means there are no input(s).
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::isStart
	 * @since   1.0
	 */
	public function testIsStart()
	{
		$this->assertTrue($this->object->isStart());

		TestReflection::setValue($this->object, 'inputs', array(1));

		$this->assertFalse($this->object->isStart());
	}

	/**
	 * Check if the place is a End Place.
	 * It means there are no ouput(s).
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::isEnd
	 * @since   1.0
	 */
	public function testIsEnd()
	{
		$this->assertTrue($this->object->isEnd());

		TestReflection::setValue($this->object, 'outputs', array(1));

		$this->assertFalse($this->object->isEnd());
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::accept
	 * @since   1.0
	 */
	public function testAccept()
	{
		$visitor = $this->getMock('PNBaseVisitor');

		$visitor->expects($this->once())
			->method('visitPlace')
			->with($this->object);

		$this->object->accept($visitor);
	}
}
