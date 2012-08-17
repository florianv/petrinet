<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test Class for PNPetrinet.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNPetrinetTest extends TestCase
{
	/**
	 * @var    PNPetrinet  A PNPetrinet instance.
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

		$this->object = new PNPetrinet('test');
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$petri = new PNPetrinet('test');
		$this->assertEquals('test', TestReflection::getValue($petri, 'name'));
		$this->assertNull(TestReflection::getValue($petri, 'startPlace'));
		$this->assertInstanceOf('PNTypeManager', TestReflection::getValue($petri, 'typeManager'));

		// Test with arguments.
		$typeManager = new PNTypeManager;
		$startPlace = new PNPlace;

		$net = new PNPetrinet('test', $startPlace, $typeManager);
		$this->assertEquals('test', TestReflection::getValue($net, 'name'));
		$this->assertEquals($startPlace, TestReflection::getValue($net, 'startPlace'));
		$this->assertEquals($typeManager, TestReflection::getValue($net, 'typeManager'));
	}

	/**
	 * Get an Instance (or create it).
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getInstance
	 * @since   1.0
	 */
	public function testGetInstance()
	{
		$this->assertInstanceOf('PNPetrinet', PNPetrinet::getInstance('test'));

		TestReflection::setValue('PNPetrinet', 'instances', array('foo' => true));

		$this->assertTrue(PNPetrinet::getInstance('foo'));
	}

	/**
	 * Create a new Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::createPlace
	 * @since   1.0
	 */
	public function testCreatePlace()
	{
		$this->assertInstanceOf('PNPlace', $this->object->createPlace());

		// Create a new place.
		$this->assertInstanceOf('PNPlace', $this->object->createPlace(new PNColorSet(array('integer', 'double'))));
	}

	/**
	 * Create a new Token.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::createToken
	 * @since   1.0
	 */
	public function testCreateToken()
	{
		$this->assertInstanceOf('PNToken', $this->object->createToken());
	}

	/**
	 * Create a new Color set.
	 *
	 * @return  PNPlace  The Place.
	 *
	 * @covers  PNPetrinet::createColorSet
	 * @since   1.0
	 */
	public function testCreateColorSet()
	{
		$colorSet = $this->object->createColorSet();

		$this->assertInstanceOf('PNColorSet', $colorSet);

		$this->assertEquals(TestReflection::getValue($this->object, 'typeManager'), TestReflection::getValue($colorSet, 'typeManager'));
	}

	/**
	 * Create a new Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::createTransition
	 * @since   1.0
	 */
	public function testCreateTransition()
	{
		$this->assertInstanceOf('PNTransition', $this->object->createTransition());
		$this->assertInstanceOf('PNTransition', $this->object->createTransition(new PNColorSet(array('integer', 'double'))));
	}

	/**
	 * Connect a place to a Transition or vice-versa.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::connect
	 * @since   1.0
	 */
	public function testConnect()
	{
		// Try connect a place to a transition with arc expression.
		$place = new PNPlace;
		$transition = new PNTransition;

		$expression = $this->getMockForAbstractClass('PNArcExpression');

		// Reset the type Manager.
		TestReflection::setValue($expression, 'typeManager', null);

		$arc = $this->object->connect($place, $transition, $expression);

		$this->assertInstanceOf('PNArcInput', $arc);
		$this->assertEquals(TestReflection::getValue($arc, 'input'), $place);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $transition);
		$this->assertEquals(TestReflection::getValue($arc, 'expression'), $expression);

		// Assert the type manager was correctly injected in the expression.
		$expression = TestReflection::getValue($arc, 'expression');
		$manager = TestReflection::getValue($expression, 'typeManager');
		$this->assertInstanceOf('PNTypeManager', $manager);

		// Try connect a transition to a place without arc expression.
		$place = new PNPlace;
		$transition = new PNTransition;

		$arc = $this->object->connect($transition, $place);

		$this->assertInstanceOf('PNArcOutput', $arc);
		$this->assertEquals(TestReflection::getValue($arc, 'input'), $transition);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $place);
		$this->assertNull(TestReflection::getValue($arc, 'expression'));
	}

	/**
	 * Tests the exception thrown by the PNPetrinet::connect method.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::connect
	 * @since   1.0
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testConnectException1()
	{
		// Try connect a place to a place.
		$this->object->connect(new PNPlace, new PNPlace);
	}

	/**
	 * Tests the exception thrown by the PNPetrinet::connect method.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::connect
	 * @since   1.0
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testConnectException2()
	{
		// Try connect a transition to a transition.
		$this->object->connect(new PNTransition, new PNTransition);
	}

	/**
	 * Test the exception if from is colored and to not colored, or vice versa.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::connect
	 *
	 * @since   1.0
	 *
	 * @expectedException InvalidArgumentException
	 */
	public function testConnectExceptionFromTo()
	{
		$this->object->connect(new PNPlace(new PNColorSet), new PNTransition);
	}

	/**
	 * Set the Petri Net start Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::setStartPlace
	 * @since   1.0
	 */
	public function testSetStartPlace()
	{
		$place = new PNPlace;
		$this->object->setStartPlace($place);
		$this->assertEquals(TestReflection::getValue($this->object, 'startPlace'), $place);
	}

	/**
	 * Set the Petri Net start Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getStartPlace
	 * @since   1.0
	 */
	public function testGetStartPlace()
	{
		TestReflection::setValue($this->object, 'startPlace', true);
		$this->assertTrue($this->object->getStartPlace());
	}

	/**
	 * Check if the Petri Net has a start Place.
	 *
	 * @return  boolean  True if it has a start Place, false otherwise.
	 *
	 * @covers  PNPetrinet::hasStartPlace
	 * @since   1.0
	 */
	public function testHasStartPlace()
	{
		$this->assertFalse($this->object->hasStartPlace());

		TestReflection::setValue($this->object, 'startPlace', new PNPlace);

		$this->assertTrue($this->object->hasStartPlace());
	}

	/**
	 * Assert the Petri Net has a start Place.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::assertHasStartPlace
	 * @since   1.0
	 */
	public function testAssertHasStartPlace()
	{
		TestReflection::setValue($this->object, 'startPlace', new PNPlace);
		$this->object->assertHasStartPlace();
	}

	/**
	 * Assert the Petri Net has a start Place.
	 *
	 * @return  void
	 *
	 * @expectedException  RuntimeException
	 *
	 * @covers  PNPetrinet::assertHasStartPlace
	 * @since   1.0
	 */
	public function testAssertHasStartPlaceException()
	{
		$this->object->assertHasStartPlace();
	}

	/**
	 * Get the Petri Net name.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getName
	 * @since   1.0
	 */
	public function testGetName()
	{
		$this->assertEquals($this->object->getName(), 'test');
	}

	/**
	 * Check if a grabber is set (the grabber has grabbed the elements).
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::hasGrabber
	 * @since   1.0
	 */
	public function testHasGrabber()
	{
		$this->assertFalse($this->object->hasGrabber());

		TestReflection::setValue($this->object, 'grabber', true);
		$this->assertTrue($this->object->hasGrabber());
	}

	/**
	 * Grab the Petri net elements.
	 *
	 * @return  void
	 *
	 * @expectedException  RuntimeException
	 * @covers  PNPetrinet::doGrab
	 * @since   1.0
	 */
	public function testDoGrabException1()
	{
		// No start Place.
		TestReflection::invoke($this->object, 'doGrab', true);
	}

	/**
	 * Grab the Petri net elements.
	 *
	 * @return  void
	 *
	 * @expectedException  RuntimeException
	 * @covers  PNPetrinet::doGrab
	 * @since   1.0
	 */
	public function testDoGrabException2()
	{
		// No start Place.
		TestReflection::invoke($this->object, 'doGrab', false);
	}

	/**
	 * Grab the Petri net elements.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::doGrab
	 * @since   1.0
	 */
	public function testDoGrab()
	{
		// Set a Start Place.
		TestReflection::setValue($this->object, 'startPlace', new PNPlace);

		// Grab with reloading.
		TestReflection::invoke($this->object, 'doGrab', true);
		$this->assertInstanceOf('PNVisitorGrabber', TestReflection::getValue($this->object, 'grabber'));

		// Reset the grabber.
		TestReflection::setValue($this->object, 'grabber', null);

		// Test it has been grabbed even with reload = false.
		TestReflection::invoke($this->object, 'doGrab', false);
		$this->assertInstanceOf('PNVisitorGrabber', TestReflection::getValue($this->object, 'grabber'));
	}

	/**
	 * Get the Petri net Places.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getPlaces
	 * @since   1.0
	 */
	public function testGetPlaces()
	{
		$mockedPn = $this->getMock('PNPetrinet', array('doGrab'), array('test'));

		$mockedPn->expects($this->once())
			->method('doGrab');

		$mockedGrabber = $this->getMock('PNVisitorGrabber');
		$mockedGrabber->expects($this->once())
			->method('getPlaces')
			->will($this->returnValue(true));

		// Inject the mocked grabber.
		TestReflection::setValue($mockedPn, 'grabber', $mockedGrabber);

		$this->assertTrue($mockedPn->getPlaces());
	}

	/**
	 * Get the Petri net Transitions.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getTransitions
	 * @since   1.0
	 */
	public function testGetTransitions()
	{
		$mockedPn = $this->getMock('PNPetrinet', array('doGrab'), array('test'));

		$mockedPn->expects($this->once())
			->method('doGrab');

		$mockedGrabber = $this->getMock('PNVisitorGrabber');
		$mockedGrabber->expects($this->once())
			->method('getTransitions')
			->will($this->returnValue(true));

		// Inject the mocked grabber.
		TestReflection::setValue($mockedPn, 'grabber', $mockedGrabber);

		$this->assertTrue($mockedPn->getTransitions());
	}

	/**
	 * Get the Petri net Input Arcs.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getInputArcs
	 * @since   1.0
	 */
	public function testGetInputArcs()
	{
		$mockedPn = $this->getMock('PNPetrinet', array('doGrab'), array('test'));

		$mockedPn->expects($this->once())
			->method('doGrab');

		$mockedGrabber = $this->getMock('PNVisitorGrabber');
		$mockedGrabber->expects($this->once())
			->method('getInputArcs')
			->will($this->returnValue(true));

		// Inject the mocked grabber.
		TestReflection::setValue($mockedPn, 'grabber', $mockedGrabber);

		$this->assertTrue($mockedPn->getInputArcs());
	}

	/**
	 * Get the Petri net Output Arcs.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getOutputArcs
	 * @since   1.0
	 */
	public function testGetOutputArcs()
	{
		$mockedPn = $this->getMock('PNPetrinet', array('doGrab'), array('test'));

		$mockedPn->expects($this->once())
			->method('doGrab');

		$mockedGrabber = $this->getMock('PNVisitorGrabber');
		$mockedGrabber->expects($this->once())
			->method('getOutputArcs')
			->will($this->returnValue(true));

		// Inject the mocked grabber.
		TestReflection::setValue($mockedPn, 'grabber', $mockedGrabber);

		$this->assertTrue($mockedPn->getOutputArcs());
	}

	/**
	 * Set the type Manager of this Petri net.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::setTypeManager
	 * @since   1.0
	 */
	public function setTypeManager()
	{
		// Reset the type manager.
		TestReflection::setValue($this->object, 'typeManager', null);

		$manager = new PNTypeManager;

		$this->object->setTypeManager($manager);

		$this->assertEquals(TestReflection::getValue($this->object, 'typeManager'), $manager);
	}

	/**
	 * Get the type Manager of this Petri net.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::setTypeManager
	 * @since   1.0
	 */
	public function testGetTypeManager()
	{
		TestReflection::setValue($this->object, 'typeManager', true);

		$this->assertTrue($this->object->getTypeManager());
	}

	/**
	 * Accept the Visitor.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::accept
	 * @since   1.0
	 */
	public function testAccept()
	{
		$visitor = $this->getMockForAbstractClass('PNBaseVisitor', array(), '', true, true, true, array('visitPetrinet'));

		$visitor->expects($this->once())
			->method('visitPetrinet')
			->with($this->object);

		$startPlace = $this->getMock('PNPlace');

		$startPlace->expects($this->once())
			->method('accept')
			->with($visitor);

		// Inject the Start Place.
		TestReflection::setValue($this->object, 'startPlace', $startPlace);

		$this->object->accept($visitor);
	}
}
