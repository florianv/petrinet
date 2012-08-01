<?php
/**
 * @package     Petrinet
 * @subpackage  Condition
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Interface for type conditions.
 *
 * @package     Petrinet
 * @subpackage  Condition
 * @since       1.0
 */
interface PNConditionType
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
	public function execute($var);
}
