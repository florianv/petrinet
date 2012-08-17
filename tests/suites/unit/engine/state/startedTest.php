<?php
/**
 * @package     Tests.Unit
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNEngineStateStarted.
 *
 * @package     Tests.Unit
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateStartedTest extends TestCase
{
	/**
	 * @var    PNEngineStateStarted  A PNEngineStateStarted instance.
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

		$engine = new PNEngine;

		$this->object = new PNEngineStateStarted($engine);
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateStarted::start
	 * @since   1.0
	 */
	public function testStart()
	{
		$this->object->start();
	}

	/**
	 * Stop the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStateStarted::stop
	 * @since   1.0
	 */
	public function testStop()
	{
		// Assert the engine has stopped state.
		$this->object->stop();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStateStopped', $engineState);
	}

	/**
	 * Pause the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStateStarted::pause
	 * @since   1.0
	 */
	public function testPause()
	{
		// Assert the engine has paused state.
		$this->object->pause();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStatePaused', $engineState);
	}

	/**
	 * Resume the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateStarted::resume
	 * @since   1.0
	 */
	public function testResume()
	{
		$this->object->resume();
	}

	/**
	 * Execute (fire) all the transitions that are currently enabled.
	 * And pass-back the execution to the Engine context.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStateStarted::run
	 * @since   1.0
	 */
	public function testRun()
	{
		// Get a mocked engine, make him return 0 enabled transitions.
		$engine = $this->getMock('PNEngine', array('refresh', 'pause', 'run'));

		$engine->expects($this->once())
			->method('refresh')
			->will($this->returnValue(array()));

		// Expects the pause method to be called.
		$engine->expects($this->once())
			->method('pause');

		$engine->expects($this->once())
			->method('run');

		// Inject the mocked engine.
		TestReflection::setValue($this->object, 'engine', $engine);

		// Run the execution.
		$this->object->run();

		// Now create a mocked engine executing a net with 2 enabled transitions (returning true).
		// Create the transitions.
		$transition1 = $this->getMock('PNTransition');
		$transition1->expects($this->once())
			->method('execute')
			->will($this->returnValue(true));

		$transition2 = $this->getMock('PNTransition');
		$transition2->expects($this->once())
			->method('execute')
			->will($this->returnValue(true));

		// Create the mocked engine.
		$engine = $this->getMock('PNEngine', array('refresh', 'run'));

		// Expect him to return the two transitions.
		$engine->expects($this->once())
			->method('refresh')
			->will($this->returnValue(array($transition1, $transition2)));

		$engine->expects($this->once())
			->method('run');

		// Inject the engine.
		TestReflection::setValue($this->object, 'engine', $engine);

		// Run the execution.
		$this->object->run();

		// Now create a mocked engine executing a net with 2 enabled transitions with the second returning false.
		// Create the transitions.
		$transition1 = $this->getMock('PNTransition');
		$transition1->expects($this->once())
			->method('execute')
			->will($this->returnValue(true));

		$transition2 = $this->getMock('PNTransition');
		$transition2->expects($this->once())
			->method('execute')
			->will($this->returnValue(false));

		// Create the mocked engine.
		$engine = $this->getMock('PNEngine', array('refresh', 'end', 'run'));

		// Expect the method refresh to return the two transitions.
		$engine->expects($this->once())
			->method('refresh')
			->will($this->returnValue(array($transition1, $transition2)));

		// Expect the 'end' method to be called.
		$engine->expects($this->once())
			->method('end');

		$engine->expects($this->once())
			->method('run');

		// Inject the engine.
		TestReflection::setValue($this->object, 'engine', $engine);

		// Run the execution.
		$this->object->run();
	}

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStateStarted::end
	 * @since   1.0
	 */
	public function testEnd()
	{
		// Assert the engine has ended state.
		$this->object->end();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStateEnded', $engineState);
	}
}
