<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Petri Nets execution Engines.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
class PNEngine
{
	/**
	 * @var    PNElementPetrinet  The Petri Net.
	 * @since  1.0
	 */
	protected $net;

	/**
	 * @var    array  The Petri Net Enabled Transitions.
	 * @since  1.0
	 */
	protected $enabledTransitions = array();

	/**
	 * @var    PNEngineStateStarted  The Started State.
	 * @since  1.0
	 */
	protected $startedState;

	/**
	 * @var    PNEngineStateStopped  The Stopped State.
	 * @since  1.0
	 */
	protected $stoppedState;

	/**
	 * @var    PNEngineStatePaused  The Paused State.
	 * @since  1.0
	 */
	protected $pausedState;

	/**
	 * @var    PNEngineStateResumed  The Resumed State.
	 * @since  1.0
	 */
	protected $resumedState;

	/**
	 * @var    PNEngineStateEnded  The Ended State.
	 * @since  1.0
	 */
	protected $endedState;

	/**
	 * @var    object  The Current State.
	 * @since  1.0
	 */
	protected $state;

	/**
	 * @var    PNEngine  The engine instances.
	 * @since  1.0
	 */
	protected static $instances = array();

	/**
	 * Constructor.
	 *
	 * @since   1.0
	 */
	public function __construct()
	{
		// Get the state instances.
		$this->startedState = new PNEngineStateStarted($this);
		$this->stoppedState = new PNEngineStateStopped($this);
		$this->pausedState = new PNEngineStatePaused($this);
		$this->resumedState = new PNEngineStateResumed($this);
		$this->endedState = new PNEngineStateEnded($this);

		// Set the current state to stopped.
		$this->state = $this->stoppedState;
	}

	/**
	 * Get an instance or create it.
	 *
	 * @param   integer  $id  The engine id.
	 *
	 * @return  PNEngine  The engine.
	 *
	 * @since   1.0
	 */
	public static function getInstance($id = 0)
	{
		if (empty(self::$instances[$id]))
		{
			self::$instances[$id] = new PNEngine;
		}

		return self::$instances[$id];
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function start()
	{
		$this->state->start();

		// Run the execution.
		$this->run();
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
		$this->state->stop();
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
		$this->state->pause();
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
		$this->state->end();
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
		$this->state->resume();

		// Run the execution.
		$this->run();
	}

	/**
	 * Main execution method.
	 * After each execution step, the state eventually modifies the engine state
	 * and pass back the execution to the Engine.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function run()
	{
		$this->state->run();
	}

	/**
	 * Refresh the enabled Transitions.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function refresh()
	{
		$transitions = $this->net->getTransitions();

		// Clear the enabled transition.
		$this->enabledTransitions = array();

		// Get the enabled Transitions.
		foreach ($transitions as $transition)
		{
			if ($transition->isEnabled())
			{
				// Store them.
				$this->enabledTransitions[] = $transition;
			}
		}
	}

	/**
	 * Get the enabled Transitions of the current Petri net.
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	public function getEnabledTransitions()
	{
		return $this->enabledTransitions;
	}

	/**
	 * Set a Petri Net for execution.
	 *
	 * @param   PNElementPetrinet  $net  The Petri Net.
	 *
	 * @return  PNEngine  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setNet(PNElementPetrinet $net)
	{
		// Set the property.
		$this->net = $net;

		return $this;
	}

	/**
	 * Get the executing Petri Net.
	 *
	 * @return  PNElementPetrinet  The Petri Net.
	 *
	 * @since   1.0
	 */
	public function getNet()
	{
		return $this->net;
	}

	/**
	 * Set the State of this Engine.
	 *
	 * @param   PNEngineState  $state  The Engine State.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setState(PNEngineState $state)
	{
		$this->state = $state;
	}

	/**
	 * Get the State of this Engine.
	 *
	 * @return  PNEngineState  The Engine State.
	 *
	 * @since   1.0
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * Check if the Engine is started.
	 *
	 * @return  boolean  True if yes, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isStarted()
	{
		return $this->state == $this->startedState;
	}

	/**
	 * Check if the engine is resumed.
	 * Resumed means re-started after a pause and running.
	 *
	 * @return  boolean  True if yes, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isResumed()
	{
		return $this->state == $this->resumedState;
	}

	/**
	 * Check if the engine execution is ended.
	 *
	 * @return  boolean  True if yes, false otherwise.
	 *
	 * @since   1.0
	 */
	public function hasEnded()
	{
		return $this->state == $this->endedState;
	}

	/**
	 * Check if the engine is paused.
	 * Paused is a state where there are no currently enabled transitions.
	 *
	 * @return  boolean  True if yes, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isPaused()
	{
		return $this->state == $this->pausedState;
	}

	/**
	 * Check if the engine is stopped.
	 * Stopped means that he can only re-start from the start node.
	 *
	 * @return  boolean  True if yes, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isStopped()
	{
		return $this->state == $this->stoppedState;
	}

	/**
	 * Get the Started State instance.
	 *
	 * @return  PNEngineStateStarted  The Started State.
	 *
	 * @since   1.0
	 */
	public function getStartedState()
	{
		return $this->startedState;
	}

	/**
	 * Get the Stopped State instance.
	 *
	 * @return  PNEngineStateStopped  The Stopped State.
	 *
	 * @since   1.0
	 */
	public function getStoppedState()
	{
		return $this->stoppedState;
	}

	/**
	 * Get the Paused State instance.
	 *
	 * @return  PNEngineStatePaused  The Paused State.
	 *
	 * @since   1.0
	 */
	public function getPausedState()
	{
		return $this->pausedState;
	}

	/**
	 * Get the Resumed State instance.
	 *
	 * @return  PNEngineStateResumed  The Resumed State.
	 *
	 * @since   1.0
	 */
	public function getResumedState()
	{
		return $this->resumedState;
	}

	/**
	 * Get the Ended State instance.
	 *
	 * @return  PNEngineStateEnded  The Ended State.
	 *
	 * @since   1.0
	 */
	public function getEndedState()
	{
		return $this->endedState;
	}
}
