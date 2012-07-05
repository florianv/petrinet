<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Resumed Engine State.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateResumed extends PNEngineStateStarted
{
	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function start()
	{
		throw new RuntimeException('Cannot start : resumed state.');
	}

	/**
	 * Resume the execution.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function resume()
	{
		throw new RuntimeException('Cannot resume : resumed state.');
	}
}
