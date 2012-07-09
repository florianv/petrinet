<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Interface for Petrinet Comparison Operators.
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
interface PNElementOperator
{
	/**
	 * Execute the Comparison.
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
