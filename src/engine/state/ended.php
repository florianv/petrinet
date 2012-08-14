<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Interface for Engine States.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateEnded extends PNEngineState
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
		throw new RuntimeException('Cannot start : execution has ended.');
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
		throw new RuntimeException('Cannot stop : execution has ended.');
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
		throw new RuntimeException('Cannot pause : execution has ended.');
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
		throw new RuntimeException('Cannot resume : execution has ended.');
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
		throw new RuntimeException('Cannot end : execution has ended.');
	}
}
