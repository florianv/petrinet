<?php
/**
 * @package     Petrinet
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Condition checking if a variable is a string.
 *
 * @package     Petrinet
 * @subpackage  Type
 * @since       1.0
 */
class PNConditionTypeString implements PNConditionType
{
	/**
	 * Evaluate the condition.
	 *
	 * @param   mixed  $var  A variable value.
	 *
	 * @return  boolean  True if the condition holds, false otherwise.
	 *
	 * @since   1.0
	 */
	public function execute($var)
	{
		return is_string($var);
	}
}
