<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Started Engine State.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngineStateStarted extends PNEngineState
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
		throw new RuntimeException('Cannot start : started state.');
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
	 * @since   1.0
	 */
	public function pause()
	{
		$this->engine->setState($this->engine->getPausedState());
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
		throw new RuntimeException('Cannot resume : started state.');
	}

	/**
	 * Execute (fire) all the transitions that are currently enabled.
	 * And pass-back the execution to the Engine context.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function run()
	{
		// Get the enabled transitions.
		$transitions = $this->engine->refresh();

		// If no enabled Transitions.
		if (empty($transitions))
		{
			// Paused state.
			$this->engine->pause();
		}

		else
		{
			// Execute all enabled Transitions.
			foreach ($transitions as $transition)
			{
				// Execute the Transition.
				if (!$transition->execute())
				{
					$this->engine->end();
				}
			}
		}

		// Pass-back the execution to the engine.
		$this->engine->run();
	}

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function end()
	{
		$this->engine->setState($this->engine->getEndedState());
	}
}
