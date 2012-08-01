<?php
/**
 * @package     Petrinet
 * @subpackage  Color
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class representing a tuple (an (ordered) array of values),
 * associated with a Token.
 *
 * @package     Petrinet
 * @subpackage  Color
 * @since       1.0
 */
class PNColor implements Countable, Serializable, IteratorAggregate
{
	/**
	 * @var    array  The data.
	 * @since  1.0
	 */
	protected $data;

	/**
	 * Constructor.
	 *
	 * @param   array  $data  The ordered data.
	 *
	 * @since   1.0
	 */
	public function __construct(array $data = array())
	{
		$this->data = $data;
	}

	/**
	 * Set the data.
	 *
	 * @param   array  $data  The ordered data.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Add data.
	 *
	 * @param   mixed    $data      The data to add.
	 * @param   integer  $position  The data position in the list.
	 *
	 * @return  PNColor  This method is chainable.
	 *
	 * @since   1.0
	 */
	public function addData($data, $position = null)
	{
		if (is_null($position))
		{
			$this->data[] = $data;
		}

		else
		{
			$this->data[$position] = $data;
		}

		return $this;
	}

	/**
	 * Get the tuple size.
	 *
	 * @return  integer  The size.
	 *
	 * @since   1.0
	 */
	public function count()
	{
		return count($this->data);
	}

	/**
	 * Get the data.
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Get an iterator on the data values.
	 *
	 * @return  Traversable  The Iterator.
	 *
	 * @since   1.0
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}

	/**
	 * Serialize the object.
	 *
	 * @return  string  The serialized object.
	 *
	 * @since   1.0
	 */
	public function serialize()
	{
		return serialize($this->data);
	}

	/**
	 * Unserialize the object.
	 *
	 * @param   string  $data  The serialized object.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function unserialize($data)
	{
		$this->data = unserialize($data);
	}
}
