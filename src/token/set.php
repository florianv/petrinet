<?php
/**
 * @package     Petrinet
 * @subpackage  Token
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class representing a multiset of tokens.
 *
 * @package     Petrinet
 * @subpackage  Token
 * @since       1.0
 */
class PNTokenSet implements Countable, IteratorAggregate
{
	/**
	 * @var    array  The tokens in this set.
	 * @since  1.0
	 */
	protected $tokens;

	/**
	 * Constructor.
	 *
	 * @param   array  $tokens  An array of tokens.
	 *
	 * @since   1.0
	 */
	public function __construct(array $tokens = array())
	{
		empty($tokens) ? $this->tokens = array() : $this->setTokens($tokens);
	}

	/**
	 * Check if a token belongs to this set.
	 *
	 * @param   PNToken  $token  The token.
	 *
	 * @return  boolean  True or false.
	 *
	 * @since   1.0
	 */
	public function exists(PNToken $token)
	{
		$tokenSignature = serialize($token);

		return isset($this->tokens[$tokenSignature]);
	}

	/**
	 * Add a token to this set.
	 *
	 * @param   PNToken  $token  The token.
	 *
	 * @return  PNTokenSet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addToken(PNToken $token)
	{
		$tokenSignature = serialize($token);

		if (isset($this->tokens[$tokenSignature]))
		{
			$this->tokens[$tokenSignature][] = $token;
		}

		else
		{
			$this->tokens[$tokenSignature] = array($token);
		}

		return $this;
	}

	/**
	 * Remove a token from this set.
	 * Only a copy of one token is removed if it appears more than
	 * one time in the set.
	 *
	 * @param   PNToken  $token  The token.
	 *
	 * @return  PNSet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function removeToken(PNToken $token)
	{
		$tokenSignature = serialize($token);

		if (isset($this->tokens[$tokenSignature]))
		{
			// If there is only one element.
			if (count($this->tokens[$tokenSignature]) == 1)
			{
				// Delete the element.
				unset($this->tokens[$tokenSignature]);
			}

			else
			{
				// Just delete one copy of it.
				array_shift($this->tokens[$tokenSignature]);
			}
		}

		return $this;
	}

	/**
	 * Set the tokens in this set.
	 *
	 * @param   array  $tokens  An array of tokens.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setTokens(array $tokens)
	{
		foreach ($tokens as $token)
		{
			$this->addToken($token);
		}
	}

	/**
	 * Get the tokens in this set.
	 *
	 * @return  array  An array of tokens.
	 *
	 * @since   1.0
	 */
	public function getTokens()
	{
		return $this->tokens;
	}

	/**
	 * Get an iterator on the token set.
	 *
	 * @return  Traversable  The Iterator.
	 *
	 * @since   1.0
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->tokens);
	}

	/**
	 * Clear the set of all its tokens.
	 *
	 * @return  array  An array of removed tokens.
	 *
	 * @since   1.0
	 */
	public function clear()
	{
		$tokens = $this->tokens;

		$this->tokens = array();

		return $tokens;
	}

	/**
	 * Get the set size.
	 *
	 * @return  integer  The number of tokens.
	 *
	 * @since   1.0
	 */
	public function count()
	{
		$count = 0;

		foreach ($this->tokens as $token)
		{
			$count += count($token);
		}

		return $count;
	}
}
