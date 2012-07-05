<?php
/**
 * @package     Petrinet
 * @subpackage  Operator
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Comparison Operator checking if leftValue is equal or less than rightValue.
 *
 * @package     Petrinet
 * @subpackage  Operator
 * @since       1.0
 */
class PNElementOperatorLte implements PNElementOperator
{
	/**
	 * Execute the Comparison.
	 *
	 * @param   mixed  $leftValue   The left value.
	 * @param   mixed  $rightValue  The right value.
	 *
	 * @return  boolean  True on success, false otherwise.
	 */
	public function execute($leftValue, $rightValue)
	{
		return $leftValue <= $rightValue;
	}
}
