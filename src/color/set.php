<?php
/**
 * @package     Petrinet
 * @subpackage  Color
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Class representing a composite data type (a tuple of PHP types).
 * Associated with a place, it is used to determine the tokens that can reside in it depending
 * on their color.
 *
 * Example :
 * $set = new PNColorSet(array('integer', 'float')) associated with a place,
 * will only allow tokens carrying data (color) which is a 2-tuple where the first element is an integer
 * and the second element a float.
 *
 * @package     Petrinet
 * @subpackage  Color
 * @since       1.0
 */
class PNColorSet
{
	/**
	 * @var    array  A tuple of types.
	 * @since  1.0
	 */
	protected $type;

	/**
	 * @var    array  The allowed types.
	 * @since  1.0
	 */
	protected $allowedTypes = array(
		'integer',
		'float',
		'boolean',
		'string',
		'array'
	);

	/**
	 * Constructor.
	 *
	 * @param   array  $type  A tuple of types.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function __construct(array $type = array())
	{
		empty($type) ? $this->type = array() : $this->setType($type);
	}

	/**
	 * Set the type.
	 *
	 * @param   array  $type  A tuple of types.
	 *
	 * @return  void
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function setType(array $type)
	{
		// Check there are only allowed types.
		$intersection = array_intersect($type, $this->allowedTypes);

		if (count($intersection) != count($type))
		{
			throw new InvalidArgumentException('A type is not allowed');
		}

		$this->type = $type;
	}

	/**
	 * Add a type.
	 *
	 * @param   string   $type      The type to add.
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
		if (in_array($type, $this->allowedTypes))
		{
			if (is_null($position))
			{
				$this->type[] = $type;
			}

			else
			{
				$this->type[$position] = $type;
			}
		}

		else
		{
			throw new InvalidArgumentException('The type :' . $type . 'is not allowed.');
		}

		return $this;
	}

	/**
	 * Get the composite type.
	 *
	 * @return  array  The composite type.
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
		$size = count($this->type);

		if (count($color) != $size)
		{
			return false;
		}

		$colorData = $color->getData();

		for ($i = 0; $i < $size; $i++)
		{
			$className = 'PNConditionType' . ucfirst($this->type[$i]);
			$class = new $className;

			if (!$class->execute($colorData[$i]))
			{
				return false;
			}
		}

		return true;
	}
}
