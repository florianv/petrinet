<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class for Petri Net Variables.
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
class PNElementVariable
{
	/**
	 * @var    string  The Variable name.
	 * @since  1.0
	 */
	protected $name;

	/**
	 * @var    string  The serialized Variable value.
	 * @since  1.0
	 */
	protected $value;

	/**
	 * Constructor.
	 *
	 * @param   string  $name   The Variable name.
	 * @param   mixed   $value  The Variablevalue.
	 *
	 * @since   1.0
	 */
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->setValue($value);
	}

	/**
	 * Get the Variable name.
	 *
	 * @return  string  The Variable name.
	 *
	 * @since   1.0
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the Variable Value.
	 *
	 * @param   mixed  $value  The Variable value.
	 *
	 * @return  void
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function setValue($value)
	{
		if (is_string($value) || is_numeric($value) || is_bool($value))
		{
			$this->value = $value;
		}

		else
		{
			throw new InvalidArgumentException('Value for the Variable is not a PHP string/float/int/bool: ' . $value);
		}
	}

	/**
	 * Get the Variable Value.
	 *
	 * @return  mixed  The Variable value.
	 *
	 * @since   1.0
	 */
	public function getValue()
	{
		return $this->value;
	}
}
