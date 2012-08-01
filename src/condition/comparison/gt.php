<?php
/**
 * @package     Petrinet
 * @subpackage  Comparison
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Comparison condition checking if leftValue is greater than rightValue.
 *
 * @package     Petrinet
 * @subpackage  Comparison
 * @since       1.0
 */
class PNConditionComparisonGt implements PNConditionComparison
{
	/**
	 * Evaluate the condition.
	 *
	 * @param   mixed  $leftValue   The left value.
	 * @param   mixed  $rightValue  The right value.
	 *
	 * @return  boolean  True on success, false otherwise.
	 *
	 * @since   1.0
	 */
	public function execute($leftValue, $rightValue)
	{
		return $leftValue > $rightValue;
	}
}
