<?php
/**
 * @package     Tests.Unit
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNEngineStateStopped.
 *
 * @package     Tests.Unit
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateStoppedTest extends TestCase
{
	/**
	 * @var    PNEngineStateStopped  A PNEngineStateStopped instance.
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

		$this->object = new PNEngineStateStopped($engine);
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineStateStopped::start
	 * @since   1.0
	 */
	public function testStart()
	{
		// Assert the engine has started state.
		$this->object->start();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStateStarted', $engineState);
	}

	/**
	 * Stop the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateStopped::stop
	 * @since   1.0
	 */
	public function testStop()
	{
		$this->object->stop();
	}

	/**
	 * Pause the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateStopped::pause
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
	 * @covers  PNEngineStateStopped::resume
	 * @since   1.0
	 */
	public function testResume()
	{
		// Assert the engine has started state.
		$this->object->resume();

		$engine = TestReflection::getValue($this->object, 'engine');

		$engineState = TestReflection::getValue($engine, 'state');

		$this->assertInstanceOf('PNEngineStateStarted', $engineState);
	}

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateStopped::end
	 * @since   1.0
	 */
	public function testEnd()
	{
		$this->object->end();
	}
}
