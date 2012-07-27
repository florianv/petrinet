<?php
/**
 * @package     Tests.Unit
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNEngineStatePaused.
 *
 * @package     Tests.Unit
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStatePausedTest extends TestCase
{
	/**
	 * @var    PNEngineStatePaused  A PNEngineStatePaused instance.
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

		$this->object = new PNEngineStatePaused($engine);
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStatePaused::start
	 * @since   1.0
	 */
	public function testStart()
	{
		// Assert the engine has resumed state.
		$this->object->start();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStateResumed', $engineState);
	}

	/**
	 * Stop the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStatePaused::stop
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
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStatePaused::pause
	 * @since   1.0
	 */
	public function testPause()
	{
		$this->object->pause();
	}

	/**
	 * Resume the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStatePaused::resume
	 * @since   1.0
	 */
	public function testResume()
	{
		// Assert the engine has resumed state.
		$this->object->resume();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStateResumed', $engineState);
	}

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStatePaused::end
	 * @since   1.0
	 */
	public function testEnd()
	{
		$this->object->end();
	}
}
