<?php
/**
 * @package     Tests.Unit
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNEngineState
 *
 * @package     Tests.Unit
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateTest extends TestCase
{
	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNEngineState::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$engine = new PNEngine;
		$state = $this->getMockForAbstractClass('PNEngineState', array($engine));
		$this->assertEquals(TestReflection::getValue($state, 'engine'), $engine);
	}
}
