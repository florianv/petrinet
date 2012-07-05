<?php
/**
 * @package     Petrinet
 * @subpackage  Base
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Interface for visitable elements.
 *
 * @package     Petrinet
 * @subpackage  Base
 * @see         http://en.wikipedia.org/wiki/Visitor_pattern
 * @since       1.0
 */
interface PNBaseVisitable
{
	/**
	 * Accept the Visitor.
	 *
	 * @param   PNBaseVisitor  $visitor  The Visitor.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function accept(PNBaseVisitor $visitor);
}
