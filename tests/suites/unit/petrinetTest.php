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
		$place = $this->object->createPlace();
		$this->assertInstanceOf('PNPlace', $place);

		$places = TestReflection::getValue($this->object, 'places');

		$this->assertEquals($place, $places[0]);

		// Create a new place.
		$place1  = $this->object->createPlace(new PNColorSet(array('integer', 'double')));

		$places = TestReflection::getValue($this->object, 'places');

		$this->assertEquals($place1, $places[1]);
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
		$transition = $this->object->createTransition();
		$this->assertInstanceOf('PNTransition', $transition);

		$transitions = TestReflection::getValue($this->object, 'transitions');

		$this->assertEquals($transition, $transitions[0]);

		// Create a new place.
		$transition1  = $this->object->createTransition(new PNColorSet(array('integer', 'double')));

		$transitions = TestReflection::getValue($this->object, 'transitions');

		$this->assertEquals($transition1, $transitions[1]);
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

		$arc = $this->object->connect($place, $transition, $expression);

		$this->assertInstanceOf('PNArcInput', $arc);
		$this->assertEquals(TestReflection::getValue($arc, 'input'), $place);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $transition);
		$this->assertEquals(TestReflection::getValue($arc, 'expression'), $expression);

		$placeOutputs = TestReflection::getValue($place, 'outputs');
		$this->assertEquals($placeOutputs[0], $arc);

		$transitionInputs = TestReflection::getValue($transition, 'inputs');
		$this->assertEquals($transitionInputs[0], $arc);

		$inputArcs = TestReflection::getValue($this->object, 'inputArcs');
		$this->assertEquals($inputArcs[0], $arc);

		// Try connect a transition to a place without arc expression.
		$place = new PNPlace;
		$transition = new PNTransition;

		$arc = $this->object->connect($transition, $place);

		$this->assertInstanceOf('PNArcOutput', $arc);
		$this->assertEquals(TestReflection::getValue($arc, 'input'), $transition);
		$this->assertEquals(TestReflection::getValue($arc, 'output'), $place);
		$this->assertNull(TestReflection::getValue($arc, 'expression'));

		$placeInputs = TestReflection::getValue($place, 'inputs');
		$this->assertEquals($placeInputs[0], $arc);

		$transitionOutputs = TestReflection::getValue($transition, 'outputs');
		$this->assertEquals($transitionOutputs[0], $arc);

		$outputArcs = TestReflection::getValue($this->object, 'outputArcs');
		$this->assertEquals($outputArcs[0], $arc);
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
	 * Ge the Petri Net name.
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
	 * Ge the Petri Net Places.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getPlaces
	 * @since   1.0
	 */
	public function testGetPlaces()
	{
		$this->assertEmpty($this->object->getPlaces());

		// Add a place.
		TestReflection::setValue($this->object, 'places', array(true));

		$places = $this->object->getPlaces();

		$this->assertTrue($places[0]);
	}

	/**
	 * Ge the Petri Net Transitions.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getTransitions
	 * @since   1.0
	 */
	public function testGetTransitions()
	{
		$this->assertEmpty($this->object->getTransitions());

		// Add a transition.
		TestReflection::setValue($this->object, 'transitions', array(true));

		$transitions = $this->object->getTransitions();

		$this->assertTrue($transitions[0]);
	}

	/**
	 * Ge the Output Arcs.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getOuputArcs
	 * @since   1.0
	 */
	public function testGetOuputArcs()
	{
		$this->assertEmpty($this->object->getOuputArcs());

		// Add an output arc.
		TestReflection::setValue($this->object, 'outputArcs', array(true));

		$outputArcs = $this->object->getOuputArcs();

		$this->assertTrue($outputArcs[0]);
	}

	/**
	 * Ge the Input Arcs.
	 *
	 * @return  void
	 *
	 * @covers  PNPetrinet::getInputArcs
	 * @since   1.0
	 */
	public function testGetInputArcs()
	{
		$this->assertEmpty($this->object->getInputArcs());

		// Add an output arc.
		TestReflection::setValue($this->object, 'inputArcs', array(true));

		$inputArcs = $this->object->getInputArcs();

		$this->assertTrue($inputArcs[0]);
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
		$visitor = $this->getMock('PNBaseVisitor');

		$visitor->expects($this->once())
			->method('visitNet')
			->with($this->object);

		$this->object->accept($visitor);
	}
}
