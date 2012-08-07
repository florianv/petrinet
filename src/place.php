<?php
/**
 * @package     Petrinet
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Places.
 *
 * @package     Petrinet
 * @subpackage  Petrinet
 * @since       1.0
 */
class PNPlace implements PNBaseVisitable
{
	/**
	 * @var    array  The input arcs of this Place.
	 * @since  1.0
	 */
	protected $inputs;

	/**
	 * @var    array  The ouput arcs of this Place.
	 * @since  1.0
	 */
	protected $outputs;

	/**
	 * @var    PNTokenSet  The tokens set.
	 * @since  1.0
	 */
	protected $tokenSet;

	/**
	 * @var    PNColorSet  The color set.
	 * @since  1.0
	 */
	protected $colorSet;

	/**
	 * Constructor.
	 *
	 * @param   PNTokenSet  $tokenSet  A token set to add to this place.
	 * @param   PNColorSet  $colorSet  A color set to add to this place.
	 * @param   array       $inputs    An array of input arcs of this place (PNArcOutput).
	 * @param   array       $outputs   An array of output arcs of this place (PNArcInput).
	 *
	 * @since   1.0
	 */
	public function __construct(PNTokenSet $tokenSet = null, PNColorSet $colorSet = null, array $inputs = array(), array $outputs = array())
	{
		// Use the given token set or create an empty one.
		$this->tokenSet = $tokenSet ? $tokenSet : new PNTokenSet;

		// Use the given color set or create an empty one.
		$this->colorSet = $colorSet ? $colorSet : new PNColorSet;

		// If no input is given.
		if (empty($inputs))
		{
			$this->inputs = $inputs;
		}

		else
		{
			// Try to add each input arc.
			foreach ($inputs as $input)
			{
				$this->addInput($input);
			}
		}

		// If no output is given.
		if (empty($outputs))
		{
			$this->outputs = $outputs;
		}

		else
		{
			// Try to add each output arc.
			foreach ($outputs as $output)
			{
				$this->addOutput($output);
			}
		}
	}

	/**
	 * Add an input Arc to this Place.
	 *
	 * @param   PNArcOutput  $arc  The input Arc.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addInput(PNArcOutput $arc)
	{
		$this->inputs[] = $arc;

		return $this;
	}

	/**
	 * Get the input Arcs of this Place.
	 *
	 * @return  array  An array of input Arc objects.
	 *
	 * @since   1.0
	 */
	public function getInputs()
	{
		return $this->inputs;
	}

	/**
	 * Add an output Arc to this Place.
	 *
	 * @param   PNArcInput  $arc  The output Arc.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addOutput(PNArcInput $arc)
	{
		$this->outputs[] = $arc;

		return $this;
	}

	/**
	 * Get the output Arc of this Place.
	 *
	 * @return  array  An array of output Arc objects.
	 *
	 * @since   1.0
	 */
	public function getOutputs()
	{
		return $this->outputs;
	}

	/**
	 * Set the color set of this Place.
	 *
	 * @param   PNColorSet  $set  The color set.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function setColorSet(PNColorSet $set)
	{
		$this->colorSet = $set;

		return $this;
	}

	/**
	 * Get the color set of this Place.
	 *
	 * @return  PNColorSet  The color set.
	 *
	 * @since   1.0
	 */
	public function getColorSet()
	{
		return $this->colorSet;
	}

	/**
	 * Check if the given token can be added to this place.
	 *
	 * @param   PNToken  $token  The token.
	 *
	 * @return  boolean  True or false.
	 *
	 * @since   1.0
	 */
	public function isAllowed(PNToken $token)
	{
		// If the token is colored.
		if ($token->isColored())
		{
			// It can be added only if its color matches the place color set.
			if (!$this->colorSet->matches($token->getColor()))
			{
				return false;
			}
		}

		else
		{
			// If the token is not colored and a color set is specified for this place.
			if (count($this->colorSet) > 0)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Add a Token in this Place.
	 *
	 * @param   PNToken  $token  The token.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addToken(PNToken $token)
	{
		$this->tokenSet->addToken($token);

		return $this;
	}

	/**
	 * Add multiple Tokens in this Place.
	 *
	 * @param   array  $tokens  An array of tokens.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addTokens(array $tokens)
	{
		foreach ($tokens as $token)
		{
			$this->tokenSet->addToken($token);
		}

		return $this;
	}

	/**
	 * Remove a Token from this Place.
	 *
	 * @param   PNToken  $token  The token.
	 *
	 * @return  PNPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function removeToken(PNToken $token)
	{
		$this->tokenSet->removeToken($token);

		return $this;
	}

	/**
	 * Remove all the Tokens from this Place.
	 *
	 * @return  array  An array of removed Tokens.
	 *
	 * @since   1.0
	 */
	public function clearTokens()
	{
		return $this->tokenSet->clear();
	}

	/**
	 * Get the Tokens in this Place.
	 *
	 * @return  array  An array of token objects.
	 *
	 * @since   1.0
	 */
	public function getTokens()
	{
		return $this->tokenSet->getTokens();
	}

	/**
	 * Get the number of tokens in this place.
	 *
	 * @return  integer  The number of tokens.
	 *
	 * @since   1.0
	 */
	public function getTokenCount()
	{
		return count($this->tokenSet);
	}

	/**
	 * Check if the place is a Start Place.
	 * It means there are no input(s).
	 *
	 * @return  boolean  True or false.
	 *
	 * @since   1.0
	 */
	public function isStart()
	{
		return empty($this->inputs) ? true : false;
	}

	/**
	 * Check if the place is a End Place.
	 * It means there are no ouput(s).
	 *
	 * @return  boolean  True or false.
	 *
	 * @since   1.0
	 */
	public function isEnd()
	{
		return empty($this->outputs) ? true : false;
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
		$visitor->visitPlace($this);
	}
}
