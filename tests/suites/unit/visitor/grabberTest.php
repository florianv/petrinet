<?php
/**
 * @package     Tests.Unit
 * @subpackage  Visitor
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNVisitorGrabber.
 *
 * @package     Tests.Unit
 * @subpackage  Visitor
 * @since       1.0
 */
class PNVisitorGrabberTest extends TestCase
{
	/**
	 * @var    PNVisitorGrabber  A PNVisitorGrabber instance.
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

		// Create a mocked Petri Net.
		$mockedNet = $this->getMock('PNPetrinet', array(), array('test'));

		$this->object = new PNVisitorGrabber($mockedNet);
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$mockedNet = $this->getMock('PNPetrinet', array('accept'), array('test'));
		$mockedNet->expects($this->once())
			->method('accept');

		new PNVisitorGrabber($mockedNet);
	}

	/**
	 * Test the depth first traversal algorithm.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testDepthFirst()
	{
		// Create a Petri Net.
		$net = new PNPetrinet('test');

		$startPlace = new PNPlace;

		$place1 = new PNPlace;
		$place2 = new PNPlace;
		$endPlace = new PNPlace;

		$transition1 = new PNTransition;
		$transition2 = new PNTransition;
		$transition3 = new PNTransition;

		$net->connect($startPlace, $transition1);
		$net->connect($startPlace, $transition2);
		$net->connect($transition1, $place1);
		$net->connect($transition2, $place2);
		$net->connect($place1, $transition3);
		$net->connect($place2, $transition3);
		$net->connect($transition3, $endPlace);

		// Inject the start place.
		TestReflection::setValue($net, 'startPlace', $startPlace);

		$grabber = new PNVisitorGrabber($net);

		$places = TestReflection::getValue($grabber, 'places');
		$transitions = TestReflection::getValue($grabber, 'transitions');
		$inputArcs = TestReflection::getValue($grabber, 'inputArcs');
		$outputArcs = TestReflection::getValue($grabber, 'outputArcs');

		$this->assertCount(4, $places);
		$this->assertCount(3, $transitions);
		$this->assertCount(4, $inputArcs);
		$this->assertCount(3, $outputArcs);

		$this->assertEquals($places[0], $startPlace);
		$this->assertEquals($places[1], $place1);
		$this->assertEquals($places[2], $endPlace);
		$this->assertEquals($places[3], $place2);

		$this->assertEquals($transitions[0], $transition1);
		$this->assertEquals($transitions[1], $transition3);
		$this->assertEquals($transitions[2], $transition2);
	}

	/**
	 * Perform the visit of a Petri Net.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::visitPetrinet
	 * @since   1.0
	 */
	public function testVisitPetrinet()
	{
		$this->assertNull($this->object->visitPetrinet(new PNPetrinet('test')));
	}

	/**
	 * Perform the visit of a Place.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::doVisitPlace
	 *
	 * @since   1.0
	 */
	public function testDoVisitPlace()
	{
		$place = new PNPlace;
		$this->object->visitPlace($place);
		$places = TestReflection::getValue($this->object, 'places');
		$this->assertEquals($place, $places[0]);
	}

	/**
	 * Perform the visit of a Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::doVisitTransition
	 * @since   1.0
	 */
	public function testDoVisitTransition()
	{
		$transition = new PNTransition;
		$this->object->visitTransition($transition);
		$transitions = TestReflection::getValue($this->object, 'transitions');
		$this->assertEquals($transition, $transitions[0]);
	}

	/**
	 * Perform the visit of an Input Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::doVisitInputArc
	 * @since   1.0
	 */
	public function testDoVisitInputArc()
	{
		$arc = new PNArcInput;
		$this->object->visitInputArc($arc);
		$arcs = TestReflection::getValue($this->object, 'inputArcs');
		$this->assertEquals($arc, $arcs[0]);
	}

	/**
	 * Perform the visit of an Output Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::doVisitOutputArc
	 * @since   1.0
	 */
	public function doVisitOutputArc()
	{
		$arc = new PNArcOutput;
		$this->object->visitOutputArc($arc);
		$arcs = TestReflection::getValue($this->object, 'outputArcs');
		$this->assertEquals($arc, $arcs[0]);
	}

	/**
	 * Get the Places.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::getPlaces
	 * @since   1.0
	 */
	public function testGetPlaces()
	{
		TestReflection::setValue($this->object, 'places', true);
		$this->assertTrue($this->object->getPlaces());
	}

	/**
	 * Get the Transitions.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::getTransitions
	 * @since   1.0
	 */
	public function testGetTransitions()
	{
		TestReflection::setValue($this->object, 'transitions', true);
		$this->assertTrue($this->object->getTransitions());
	}

	/**
	 * Get the input Arcs.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::getInputArcs
	 * @since   1.0
	 */
	public function testGetInputArcs()
	{
		TestReflection::setValue($this->object, 'inputArcs', true);
		$this->assertTrue($this->object->getInputArcs());
	}

	/**
	 * Get the output Arcs.
	 *
	 * @return  void
	 *
	 * @covers  PNVisitorGrabber::getInputArcs
	 * @since   1.0
	 */
	public function testGetOutputArcs()
	{
		TestReflection::setValue($this->object, 'outputArcs', true);
		$this->assertTrue($this->object->getOutputArcs());
	}
}
