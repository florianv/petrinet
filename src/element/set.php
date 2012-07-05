<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class representing a Mathematical multiset.
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
class PNElementSet implements Countable
{
	/**
	 * @var    array  The elements in this set.
	 * @since  1.0
	 */
	protected $elements = array();

	/**
	 * Add an element to this set.
	 *
	 * @param   object  $element  The element.
	 *
	 * @return  PNElementSet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function add($element)
	{
		$this->elements[] = $element;

		return $this;
	}

	/**
	 * Add multiple elements in this set.
	 *
	 * @param   array  $elements  An array of elements.
	 *
	 * @return  PNElementSet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addMultiple(array $elements)
	{
		$this->elements = array_merge($this->elements, $elements);

		return $this;
	}

	/**
	 * Remove an element from this set.
	 *
	 * @param   object  $element  The element.
	 *
	 * @return  PNElementSet  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function remove($element)
	{
		$index = array_search($element, $this->elements, true);

		if (is_int($index))
		{
			unset($this->elements[$index]);
		}

		return $this;
	}

	/**
	 * Clear the set of all its elements.
	 *
	 * @return  array  An array of removed elements.
	 *
	 * @since   1.0
	 */
	public function clear()
	{
		// Get the elements.
		$elements = $this->elements;

		// Clear the set.
		$this->elements = array();

		// Return the removed elements.
		return $elements;
	}

	/**
	 * Count the number of elements in this set.
	 *
	 * @return  integer  The number of elements.
	 *
	 * @since   1.0
	 */
	public function count()
	{
		return count($this->elements);
	}

	/**
	 * Get the elements in this set.
	 *
	 * @return  array  An array of elements.
	 *
	 * @since   1.0
	 */
	public function getElements()
	{
		return $this->elements;
	}
}
