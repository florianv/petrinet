<?php
/**
 * @package     Tests.Unit
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNEngineStateEnded.
 *
 * @package     Tests.Unit
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateEndedTest extends TestCase
{
	/**
	 * @var    PNEngineStateEnded  A PNEngineStateEnded instance.
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

		$this->object = new PNEngineStateEnded($engine);
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateEnded::start
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
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateEnded::stop
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
	 * @covers  PNEngineStateEnded::pause
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
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateEnded::resume
	 * @since   1.0
	 */
	public function testResume()
	{
		$this->object->resume();
	}

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateEnded::end
	 * @since   1.0
	 */
	public function testEnd()
	{
		$this->object->end();
	}
}
