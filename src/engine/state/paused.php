<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Paused Engine State.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStatePaused extends PNEngineState
{
	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function start()
	{
		// Resume the execution.
		$this->engine->setState($this->engine->getResumedState());
	}

	/**
	 * Stop the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function stop()
	{
		$this->engine->setState($this->engine->getStoppedState());
	}

	/**
	 * Pause the execution.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function pause()
	{
		throw new RuntimeException('Cannot pause : paused state.');
	}

	/**
	 * Resume the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function resume()
	{
		$this->engine->setState($this->engine->getResumedState());
	}

	/**
	 * Main execution method.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function run()
	{
		// No exception.
	}

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function end()
	{
		throw new RuntimeException('Cannot end : paused state.');
	}
}
