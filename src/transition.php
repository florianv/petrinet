<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Transitions.
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
class PNTransition implements PNBaseVisitable
{
	/**
	 * @var    array  The input Arcs of this Transition.
	 * @since  1.0
	 */
	protected $inputs;

	/**
	 * @var    array  The ouput Arcs of this Transition.
	 * @since  1.0
	 */
	protected $outputs;

	/**
	 * @var    PNGuard  A Guard for this Transition.
	 * @since  1.0
	 */
	protected $guard;

	/**
	 * Constructor.
	 *
	 * @param   PNGuard  $guard    A Guard for this Transition.
	 * @param   array           $inputs   The input arcs of this Transition (PNArcInput).
	 * @param   array           $outputs  The output arcs of this Transition (PNArcOutput).
	 *
	 * @since   1.0
	 */
	public function __construct(PNGuard $guard = null, array $inputs = array(), array $outputs = array())
	{
		$this->guard = $guard;

		if (empty($inputs))
		{
			$this->inputs = $inputs;
		}

		else
		{
			foreach ($inputs as $input)
			{
				$this->addInput($input);
			}
		}

		if (empty($outputs))
		{
			$this->outputs = $outputs;
		}

		else
		{
			foreach ($outputs as $output)
			{
				$this->addOutput($output);
			}
		}
	}

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
	 * Get the input Arcs of this Transition.
	 *
	 * @return  array  An array of PNArc objects.
	 *
	 * @since   1.0
	 */
	public function getInputs()
	{
		return $this->inputs;
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
	 * Get the output Arcs of this Transition.
	 *
	 * @return  array  An array of PNArc objects.
	 *
	 * @since   1.0
	 */
	public function getOutputs()
	{
		return $this->outputs;
	}

	/**
	 * Set a Guard for this Transition.
	 *
	 * @param   PNGuard  $guard  The Guard.
	 *
	 * @return  PNTransition This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setGuard(PNGuard $guard)
	{
		$this->guard = $guard;

		return $this;
	}

	/**
	 * Get the Guard of this Transition.
	 *
	 * @return  PNGuard  $guard  The Guard.
	 *
	 * @since   1.0
	 */
	public function getGuard()
	{
		return $this->guard;
	}

	/**
	 * Check if this Transition is Guarded.
	 *
	 * @return  boolean  True if Guarded, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isGuarded()
	{
		return $this->guard ? true : false;
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
		// If the Transition is Guarded.
		if ($this->isGuarded())
		{
			// Verify the Guard returns true.
			if (!$this->guard->execute())
			{
				return false;
			}
		}

		// A transition is enabled if each input place p of t is marked with at least
		// w(p,t) tokens, where w(p,t) is the weight of the arc from p to t.
		foreach ($this->inputs as $arc)
		{
			// Get the input place
			$place = $arc->getInput();

			if ($place->getTokenCount() < $arc->getWeight())
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Execute (fire) the Transition (it supposes it is enabled).
	 * A firing of an enabled transition t removes w(p,t) tokens from each
	 * input place p of t, and adds w(t,p) tokens to each output place p of t, where
	 * w(p,t) is the weight of the arc from p to t and w(p,t) is the weight of the arc from t to p
	 *
	 * @return  boolean  False if it's the last Transition, true if not.
	 *
	 * @since   1.0
	 */
	public function execute()
	{
		foreach ($this->inputs as $inputArc)
		{
			$inputPlace = $inputArc->getInput();
			$tokens = $inputPlace->getTokens();
			$inputWeight = $inputArc->getWeight();

			for ($i = 0; $i < $inputWeight; $i++)
			{
				$inputPlace->removeToken($tokens[$i]);
			}
		}

		foreach ($this->outputs as $arc)
		{
			$place = $arc->getOutput();

			for ($i = 0; $i < $arc->getWeight(); $i++)
			{
				// Add tokens to the output places.
				$place->addToken(new stdClass);
			}

			// If the place is an End Place (Petrinet has ended).
			if ($place->isEnd())
			{
				return false;
			}
		}

		return true;
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
