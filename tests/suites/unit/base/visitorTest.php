<?php
/**
 * @package     Tests.Unit
 * @subpackage  Base
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNBaseVisitor.
 *
 * @package     Tests.Unit
 * @subpackage  Base
 * @since       1.0
 */
class PNBaseVisitorTest extends TestCase
{
	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNBaseVisitor::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$visitor = $this->getMockForAbstractClass('PNBaseVisitor');

		$this->assertInstanceOf('SplObjectStorage', TestReflection::getValue($visitor, 'visitedPlaces'));
		$this->assertInstanceOf('SplObjectStorage', TestReflection::getValue($visitor, 'visitedTransitions'));
		$this->assertInstanceOf('SplObjectStorage', TestReflection::getValue($visitor, 'visitedArcs'));
	}

	/**
	 * Visit a Place.
	 *
	 * @return  void
	 *
	 * @covers  PNBaseVisitor::visitPlace
	 * @since   1.0
	 */
	public function testVisitPlace()
	{
		$place = new PNPlace;

		// Create a Mock for SplObjectStorage.
		$storage = $this->getMock('SplObjectStorage');

		// Make the contains method returning false.
		$storage->expects($this->once())
			->method('contains')
			->will($this->returnValue(false));

		// Expects the method attach to be called.
		$storage->expects($this->once())
			->method('attach')
			->with($place);

		// Expects the method doVisitPlace to be called.
		$visitorMock = $this->getMockForAbstractClass('PNBaseVisitor');
		$visitorMock->expects($this->once())
			->method('doVisitPlace')
			->with($place);

		// Inject the mocked storage.
		TestReflection::setValue($visitorMock, 'visitedPlaces', $storage);

		// Assert the place has been visited.
		$this->assertTrue($visitorMock->visitPlace($place));

		// Try to visit it one more time.
		// For this make the method contains of SplObjectStorage returning true.
		$storage = $this->getMock('SplObjectStorage');
		$storage->expects($this->once())
			->method('contains')
			->will($this->returnValue(true));

		// Expects the method attach to never be called.
		$storage->expects($this->never())
			->method('attach');

		// Expects the method doVisitPlace to never be called.
		$visitorMock = $this->getMockForAbstractClass('PNBaseVisitor');
		$visitorMock->expects($this->never())
			->method('doVisitPlace');

		// Inject the mocked storage.
		TestReflection::setValue($visitorMock, 'visitedPlaces', $storage);

		// Assert the place has not been visited.
		$this->assertFalse($visitorMock->visitPlace($place));
	}

	/**
	 * Visit a Transition.
	 *
	 * @return  void
	 *
	 * @covers  PNBaseVisitor::visitTransition
	 * @since   1.0
	 */
	public function testVisitTransition()
	{
		$transition = new PNTransition;

		// Create a Mock for SplObjectStorage.
		$storage = $this->getMock('SplObjectStorage');

		// Make the contains method returning false.
		$storage->expects($this->once())
			->method('contains')
			->will($this->returnValue(false));

		// Expects the method attach to be called.
		$storage->expects($this->once())
			->method('attach')
			->with($transition);

		// Expects the method doVisitTransition to be called.
		$visitorMock = $this->getMockForAbstractClass('PNBaseVisitor');
		$visitorMock->expects($this->once())
			->method('doVisitTransition')
			->with($transition);

		// Inject the mocked storage.
		TestReflection::setValue($visitorMock, 'visitedTransitions', $storage);

		// Assert the transition has been visited.
		$this->assertTrue($visitorMock->visitTransition($transition));

		// Try to visit it one more time.
		// For this make the method contains of SplObjectStorage returning true.
		$storage = $this->getMock('SplObjectStorage');
		$storage->expects($this->once())
			->method('contains')
			->will($this->returnValue(true));

		// Expects the method attach to never be called.
		$storage->expects($this->never())
			->method('attach');

		// Expects the method doVisitTransition to never be called.
		$visitorMock = $this->getMockForAbstractClass('PNBaseVisitor');
		$visitorMock->expects($this->never())
			->method('doVisitTransition');

		// Inject the mocked storage.
		TestReflection::setValue($visitorMock, 'visitedTransitions', $storage);

		// Assert the Transition has not been visited.
		$this->assertFalse($visitorMock->visitTransition($transition));
	}

	/**
	 * Visit an Input Arc.
	 *
	 * @return  void
	 *
	 * @covers  PNBaseVisitor::visitArc
	 * @since   1.0
	 */
	public function testVisitArc()
	{
		$arc = new PNArc;

		// Create a Mock for SplObjectStorage.
		$storage = $this->getMock('SplObjectStorage');

		// Make the contains method returning false.
		$storage->expects($this->once())
			->method('contains')
			->will($this->returnValue(false));

		// Expects the method attach to be called.
		$storage->expects($this->once())
			->method('attach')
			->with($arc);

		// Expects the method doVisitArc to be called.
		$visitorMock = $this->getMockForAbstractClass('PNBaseVisitor');
		$visitorMock->expects($this->once())
			->method('doVisitArc')
			->with($arc);

		// Inject the mocked storage.
		TestReflection::setValue($visitorMock, 'visitedArcs', $storage);

		// Assert the arc has been visited.
		$this->assertTrue($visitorMock->visitArc($arc));

		// Try to visit it one more time.
		// For this make the method contains of SplObjectStorage returning true.
		$storage = $this->getMock('SplObjectStorage');
		$storage->expects($this->once())
			->method('contains')
			->will($this->returnValue(true));

		// Expects the method attach to never be called.
		$storage->expects($this->never())
			->method('attach');

		// Expects the method doVisitArc to never be called.
		$visitorMock = $this->getMockForAbstractClass('PNBaseVisitor');
		$visitorMock->expects($this->never())
			->method('doVisitArc');

		// Inject the mocked storage.
		TestReflection::setValue($visitorMock, 'visitedArcs', $storage);

		// Assert the arc has not been visited.
		$this->assertFalse($visitorMock->visitArc($arc));
	}
}
