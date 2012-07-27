<?php
/**
 * @package     Tests.Unit
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNEngineStateResumed.
 *
 * @package     Tests.Unit
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateResumedTest extends TestCase
{
	/**
	 * @var    PNEngineStateResumed  A PNEngineStateResumed instance.
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

		$this->object = new PNEngineStateResumed($engine);
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateResumed::start
	 * @since   1.0
	 */
	public function testStart()
	{
		$this->object->start();
	}

	/**
	 * Resume the execution.
	 *
	 * @return  void
	 *
	 * @expectedException RuntimeException
	 *
	 * @covers  PNEngineStateResumed::resume
	 * @since   1.0
	 */
	public function testResume()
	{
		$this->object->resume();
	}
}
