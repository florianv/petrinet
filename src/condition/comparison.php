<?php
/**
 * @package     Petrinet
 * @subpackage  Condition
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Interface for comparison conditions.
 *
 * @package     Petrinet
 * @subpackage  Condition
 * @since       1.0
 */
interface PNConditionComparison
{
	/**
	 * Execute the condition.
	 *
	 * @param   mixed  $leftValue   The left value.
	 * @param   mixed  $rightValue  The right value.
	 *
	 * @return  boolean  True on success, false otherwise.
	 *
	 * @since   1.0
	 */
	public function execute($leftValue, $rightValue);
}
