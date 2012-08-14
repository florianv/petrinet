<?php
/**
 * @package     Petrinet
 * @subpackage  Color
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class representing a composite type (a tuple of types).
 * Associated with a place, it is used to determine the tokens that can reside in it depending
 * on their color.
 *
 * @package     Petrinet
 * @subpackage  Color
 * @since       1.0
 */
class PNColorSet implements Countable, Serializable, IteratorAggregate
{
	/**
	 * @var    array  The composite type.
	 * @since  1.0
	 */
	protected $type;

	/**
	 * @var    PNTypeManager  The type Manager.
	 * @since  1.0
	 */
	protected $typeManager;

	/**
	 * Constructor.
	 *
	 * @param   array          $type     The composite type.
	 * @param   PNTypeManager  $manager  The type Manager.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function __construct(array $type = array(), PNTypeManager $manager = null)
	{
		// Use the given type manager, or create a new one.
		$this->typeManager = $manager ? $manager : new PNTypeManager;

		// Set the type.
		empty($type) ? $this->type = array() : $this->setType($type);
	}

	/**
	 * Set the composite type, only if it is composed of allowed types.
	 *
	 * @param   array  $types  The composite type.
	 *
	 * @return  void
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function setType(array $types)
	{
		// Verify all types are allowed.
		foreach ($types as $type)
		{
			if (!$this->typeManager->isAllowed($type))
			{
				throw new InvalidArgumentException('Type : ' . $type . ' is not allowed.');
			}
		}

		// Store them.
		$this->type = $types;
	}

	/**
	 * Add a type at the given position in the tuple.
	 * If no position is specified, it is added at the end.
	 *
	 * @param   string   $type      The type name to add.
	 * @param   integer  $position  The position in the tuple.
	 *
	 * @return  PNColorSet  This method is chainable.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function addType($type, $position = null)
	{
		// If the type is allowed.
		if ($this->typeManager->isAllowed($type))
		{
			// Add it at the end.
			if (is_null($position))
			{
				$this->type[] = $type;
			}

			// Insert it at the given position.
			else
			{
				$this->type[$position] = $type;
			}
		}

		else
		{
			throw new InvalidArgumentException('The type : ' . $type . 'is not allowed.');
		}

		return $this;
	}

	/**
	 * Get the set type.
	 *
	 * @return  array  The set type.
	 *
	 * @since   1.0
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Check if the given color matches the color set definition.
	 *
	 * @param   PNColor  $color  The color.
	 *
	 * @return  boolean  True if it's the case, false otherwise.
	 *
	 * @since   1.0
	 */
	public function matches(PNColor $color)
	{
		return $this->typeManager->matchMultiple($color->getData(), $this->type);
	}

	/**
	 * Get an iterator on the color set.
	 *
	 * @return  Traversable  The Iterator.
	 *
	 * @since   1.0
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->type);
	}

	/**
	 * Get the set size.
	 *
	 * @return  integer  The number of types.
	 *
	 * @since   1.0
	 */
	public function count()
	{
		return count($this->type);
	}

	/**
	 * Serialize the set.
	 *
	 * @return  string  The serialized set.
	 *
	 * @since   1.0
	 */
	public function serialize()
	{
		return serialize(array($this->type, $this->typeManager));
	}

	/**
	 * Unserialize the set.
	 *
	 * @param   string  $set  The serialized set.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function unserialize($set)
	{
		list($this->type, $this->typeManager) = unserialize($set);
	}
}
