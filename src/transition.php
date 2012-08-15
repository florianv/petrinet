<?php
/**
 * @package     Petrinet
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Transitions.
 *
 * @package     Petrinet
 * @subpackage  Petrinet
 * @since       1.0
 */
class PNTransition extends PNNode
{
	/**
	 * Add an input Arc to this Transition.
	 *
	 * @param   PNArcInput  $arc  The input Arc.
	 *
	 * @return  PNTransition This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addInput(PNArcInput $arc)
	{
		$this->inputs[] = $arc;

		return $this;
	}

	/**
	 * Add an ouput Arc to this Transition.
	 *
	 * @param   PNArcOutput  $arc  The input Arc.
	 *
	 * @return  PNTransition This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addOutput(PNArcOutput $arc)
	{
		$this->outputs[] = $arc;

		return $this;
	}

	/**
	 * Check if the Transition is loaded.
	 * To be loaded it must have at least one input and one output.
	 *
	 * @return  boolean  True if loaded, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isLoaded()
	{
		return $this->hasInput() && $this->hasOutput();
	}

	/**
	 * Verify if this Transition is Enabled.
	 *
	 * @return  boolean  True is enabled, false if not.
	 *
	 * @since   1.0
	 */
	public function isEnabled()
	{
		// Assert the Transition is Loaded.
		$this->assertIsLoaded();

		// If we are in Colored Petri Net mode.
		if ($this->isColoredMode())
		{
			return $this->doIsEnabledColored();
		}

		// Basic Petri Nets.
		else
		{
			return $this->doIsEnabledBasic();
		}
	}

	/**
	 * Check if the Transition is enabled for basic (not colored Petri Nets).
	 *
	 * @return  boolean  True is enabled, false if not.
	 *
	 * @since   1.0
	 */
	protected function doIsEnabledBasic()
	{
		// Check there is at least one token in each input Place.
		foreach ($this->inputs as $arc)
		{
			$place = $arc->getInput();

			if ($place->getTokenCount() < 1)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Check if the Transition is enabled for color Petri Nets.
	 *
	 * @return  boolean  True is enabled, false if not.
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	protected function doIsEnabledColored()
	{
		throw new RuntimeException('Colored Petri nets not allowed atm.');
	}

	/**
	 * Execute (fire) the Transition (it supposes it is enabled).
	 *
	 * @return  boolean  False if it's the last Transition, true if not.
	 *
	 * @since   1.0
	 */
	public function execute()
	{
		// If we are in Colored Petri Net mode.
		if ($this->isColoredMode())
		{
			$return = $this->doExecuteColored();
		}

		// Basic Petri Nets.
		else
		{
			$return = $this->doExecuteBasic();
		}

		// Perform custom execution.
		$this->doExecute();

		return $return;
	}

	/**
	 * Perform custom execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function doExecute()
	{

	}

	/**
	 * Fire the Transition in normal mode.
	 *
	 * @return  boolean  False if it's the last Transition, true if not.
	 *
	 * @since   1.0
	 */
	protected function doExecuteBasic()
	{
		// Remove one token from each input Place.
		foreach ($this->inputs as $arc)
		{
			$place = $arc->getInput();
			$place->removeToken(new PNToken);
		}

		// Init variable.
		$return = true;

		// Add one token to each output Place.
		foreach ($this->outputs as $arc)
		{
			$place = $arc->getOutput();
			$place->addToken(new PNToken);

			// If the place is the last one, finish the execution and return false later.
			if ($place->isEnd())
			{
				$return = false;
			}
		}

		return $return;
	}

	/**
	 * Fire the Transition in colored mode.
	 *
	 * @return  boolean  False if it's the last Transition, true if not.
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.0
	 */
	protected function doExecuteColored()
	{
		throw new RuntimeException('Colored Petri nets not allowed atm.');
	}

	/**
	 * Accept the Visitor.
	 *
	 * @param   PNBaseVisitor  $visitor  The Visitor.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function accept(PNBaseVisitor $visitor)
	{
		$visitor->visitTransition($this);
	}
}
