<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Places.
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
class PNElementPlace implements PNBaseVisitable
{
	/**
	 * @var    array  The input Arcs of this Place.
	 * @since  1.0
	 */
	protected $inputs = array();

	/**
	 * @var    array  The ouput Arcs of this Place.
	 * @since  1.0
	 */
	protected $outputs = array();

	/**
	 * @var    PNElementSet  The tokens Set.
	 * @since  1.0
	 */
	protected $tokenSet;

	/**
	 * Constructor.
	 *
	 * @since  1.0
	 */
	public function __construct()
	{
		$this->tokenSet = new PNElementSet;
	}

	/**
	 * Add an input Arc to this Place.
	 *
	 * @param   PNElementArcOutput  $arc  The input Arc.
	 *
	 * @return  PNElementPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addInput(PNElementArcOutput $arc)
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
	 * @param   PNElementArcInput  $arc  The output Arc.
	 *
	 * @return  PNElementPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addOutput(PNElementArcInput $arc)
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
	 * Add a Token in this Place.
	 *
	 * @param   PNElementToken  $token  The token.
	 *
	 * @return  PNElementPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addToken($token)
	{
		$this->tokenSet->add($token);

		return $this;
	}

	/**
	 * Add multiple Tokens in this Place.
	 *
	 * @param   array  $tokens  An array of tokens.
	 *
	 * @return  PNElementPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addTokens(array $tokens)
	{
		$this->tokenSet->addMultiple($tokens);

		return $this;
	}

	/**
	 * Remove a Token from this Place.
	 *
	 * @param   PNElementToken  $token  The token.
	 *
	 * @return  PNElementPlace  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function removeToken($token)
	{
		$this->tokenSet->remove($token);

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
		return $this->tokenSet->getElements();
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
