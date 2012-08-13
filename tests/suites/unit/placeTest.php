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
		$tokenSetMock = $this->getMock('PNTokenSet');
		TestReflection::setValue($this->object, 'tokenSet', $tokenSetMock);
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

		$this->assertInstanceOf('PNTokenSet', TestReflection::getValue($place, 'tokenSet'));
		$this->assertInstanceOf('PNColorSet', TestReflection::getValue($place, 'colorSet'));
		$this->assertEmpty(TestReflection::getValue($place, 'inputs'));
		$this->assertEmpty(TestReflection::getValue($place, 'outputs'));

		// Test with params.
		$tokenSet = new PNTokenSet;
		$colorSet = new PNColorSet;
		$inputs = array(new PNArcOutput, new PNArcOutput);
		$outputs = array(new PNArcInput, new PNArcInput);

		$place = new PNPlace($colorSet, $tokenSet, $inputs, $outputs);

		$this->assertEquals($tokenSet, TestReflection::getValue($place, 'tokenSet'));
		$this->assertEquals($colorSet, TestReflection::getValue($place, 'colorSet'));
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
	public function testAddInputError()
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
	public function testAddOutputError()
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
	 * Set the color set of this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::setColorSet
	 * @since   1.0
	 */
	public function testSetColorSet()
	{
		$set = new PNColorSet(array('integer', 'double'));
		$this->object->setColorSet($set);

		$this->assertEquals(TestReflection::getValue($this->object, 'colorSet'), $set);
	}

	/**
	 * Get the color set of this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::getColorSet
	 * @since   1.0
	 */
	public function testGetColorSet()
	{
		TestReflection::setValue($this->object, 'colorSet', true);
		$this->assertTrue($this->object->getColorSet());
	}

	/**
	 * Check if the given token can be added to this place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::isAllowed
	 * @since   1.0
	 */
	public function testIsAllowed()
	{
		$colorSet = new PNColorSet(array('integer', 'double', 'double'));
		TestReflection::setValue($this->object, 'colorSet', $colorSet);

		$color = new PNColor(array(1, 1.2, 2.2));
		$token = new PNToken($color);

		// Try with an allowed token.
		$this->assertTrue($this->object->isAllowed($token));

		$color = new PNColor(array(1, '1.2', 2.2));
		$token = new PNToken($color);

		// Try with a not allowed token.
		$this->assertFalse($this->object->isAllowed($token));

		// Try with an non coloured token.
		$token = new PNToken;
		$this->assertFalse($this->object->isAllowed($token));

		// Try with a non specified color set and notcolored token.
		TestReflection::setValue($this->object, 'colorSet', new PNColorSet);
		$this->assertTrue($this->object->isAllowed($token));
	}

	/**
	 * Add a Token in this Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addTokenWithoutCheck
	 * @since   1.0
	 */
	public function testAddTokenWithoutCheck()
	{
		// Get the mocked tokenset.
		$mock = TestReflection::getValue($this->object, 'tokenSet');

		$mock->expects($this->once())
			->method('addToken');

		$this->object->addToken(new PNToken);
	}

	/**
	 * Add a Token in this Place, only if it is allowed.
	 *
	 * @return  void
	 *
	 * @covers  PNPlace::addToken
	 * @since   1.0
	 */
	public function testAddToken()
	{
		// Test with an allowed token.
		$color = new PNColor(array(1, 'test'));
		$token = new PNToken($color);

		$colorSet = new PNColorSet(array('integer', 'string'));
		TestReflection::setValue($this->object, 'colorSet', $colorSet);

		$this->assertTrue($this->object->addToken($token));

		// Test with non allowed token.
		$color = new PNColor(array(1, 1));
		$token = new PNToken($color);

		$this->assertFalse($this->object->addToken($token));
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
		// Set the token set.
		TestReflection::setValue($this->object, 'tokenSet', new PNTokenSet);

		// Test with a allowed tokens.
		$color1 = new PNColor(array(1, 'test'));
		$token1 = new PNToken($color1);

		$color2 = new PNColor(array(22, 'hello'));
		$token2 = new PNToken($color2);

		// Set the place color set.
		$colorSet = new PNColorSet(array('integer', 'string'));
		TestReflection::setValue($this->object, 'colorSet', $colorSet);

		// Add the tokens.
		$this->object->addTokens(array($token1, $token2));

		$tokenSet = TestReflection::getValue($this->object, 'tokenSet');
		$tokens = $tokenSet->getTokens();

		$tokens = array_values($tokens);

		$this->assertContains($token1, $tokens[0]);
		$this->assertContains($token2, $tokens[1]);

		// Reset the tokenSet.
		TestReflection::setValue($this->object, 'tokenSet', new PNTokenSet);

		// Test with non allowed tokens.
		$color1 = new PNColor(array('test', 'test'));
		$token1 = new PNToken($color1);

		$color2 = new PNColor(array(array(3), 'hello'));
		$token2 = new PNToken($color2);

		// Add the tokens.
		$this->object->addTokens(array($token1, $token2));

		$tokenSet = TestReflection::getValue($this->object, 'tokenSet');
		$tokens = $tokenSet->getTokens();

		$this->assertEmpty($tokens);
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
			->method('removeToken');

		$this->object->removeToken(new PNToken);
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
			->method('getTokens');

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
