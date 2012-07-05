<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Stopped Engine State.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateStopped extends PNEngineState
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
		$this->engine->setState($this->engine->getStartedState());
	}

	/**
	 * Stop the execution.
	 *
	 * @return  void
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	public function stop()
	{
		throw new RuntimeException('Cannot stop : stopped state.');
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
		throw new RuntimeException('Cannot pause : stopped state.');
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
		// Re-start the execution.
		$this->engine->setState($this->engine->getStartedState());
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
		throw new RuntimeException('Cannot end : stopped state.');
	}
}
