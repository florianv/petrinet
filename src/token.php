<?php
/**
 * @package     Petrinet
 * @subpackage  Petrinet
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Petri Net (Colored) Tokens.
 *
 * @package     Petrinet
 * @subpackage  Petrinet
 * @since       1.0
 */
class PNToken implements Serializable
{
	/**
	 * @var    PNColor  The token color.
	 * @since  1.0
	 */
	protected $color;

	/**
	 * Constructor.
	 *
	 * @param   PNColor  $color  The token color.
	 *
	 * @since   1.0
	 */
	public function __construct(PNColor $color = null)
	{
		$this->color = $color;
	}

	/**
	 * Check if the token is colored.
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isColored()
	{
		return !is_null($this->color);
	}

	/**
	 * Get the Token color.
	 *
	 * @return  PNColor  The token color.
	 *
	 * @since   1.0
	 */
	public function getColor()
	{
		return $this->color;
	}

	/**
	 * Set the Token color.
	 *
	 * @param   PNColor  $color  The token color.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setColor(PNColor $color)
	{
		$this->color = $color;
	}

	/**
	 * Serialize the token.
	 *
	 * @return  string  The serialized token.
	 *
	 * @since   1.0
	 */
	public function serialize()
	{
		return serialize($this->color);
	}

	/**
	 * Unserialize the token.
	 *
	 * @param   string  $token  The serialized token.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function unserialize($token)
	{
		$this->color = unserialize($token);
	}
}
