<?php
/**
 * @package     Petrinet
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Core class which manages the variable types in the system.
 *
 * @package     Petrinet
 * @subpackage  Type
 * @since       1.0
 */
class PNTypeManager
{
	/**
	 * @var    array  Registered basic types.
	 * @since  1.0
	 */
	protected $basicTypes = array(
		'integer',
		'double', // Float
		'boolean',
		'string',
		'array',
	);

	/**
	 * @var    array  Registered custom types (anything besides objects).
	 * @since  1.0
	 */
	protected $customTypes = array();

	/**
	 * @var    array  Registered object types (class names).
	 * @since  1.0
	 */
	protected $objectTypes = array();

	/**
	 * Register an object type to the manager (a class name).
	 *
	 * @param   string  $className  The class name.
	 *
	 * @return  boolean  True if successfully registered, false otherwise.
	 *
	 * @since   1.0
	 */
	public function registerObjectType($className)
	{
		// If the type already exists return true.
		if (in_array($className, $this->objectTypes))
		{
			return true;
		}

		// Register it, only if it exists.
		if (class_exists($className))
		{
			$this->objectTypes[] = $className;
			return true;
		}

		return false;
	}

	/**
	 * Register a custom type to the system.
	 * A custom type is anything besides an instance of a given class.
	 *
	 * @param   string  $typeName  The type name.
	 * @param   string  $parent    The parent type name (integer, double, boolean, array or string).
	 * @param   PNType  $type      A type object.
	 *
	 * @return  boolean  True if successfully registered.
	 *
	 * @throws  UnexpectedValueException
	 *
	 * @since   1.0
	 */
	public function registerCustomType($typeName, $parent, PNType $type = null)
	{
		// If the parent type doesn't exist.
		if (!in_array($parent, $this->basicTypes))
		{
			return false;
		}

		// If the type already exists return true.
		if (isset($this->customTypes[$parent][$typeName]))
		{
			return true;
		}

		// If no type is given.
		if (is_null($type))
		{
			// Try to find it.
			if (!class_exists($typeName))
			{
				throw new UnexpectedValueException('Type class not found for type : ' . $typeName);
			}

			else
			{
				// Register the type name and the type class.
				$this->customTypes[$parent][$typeName] = $type;
				return true;
			}
		}

		else
		{
			// Register the type name and the type class.
			$this->customTypes[$parent][$typeName] = $type;
			return true;
		}
	}

	/**
	 * Check if the given type is 'basic'.
	 *
	 * @param   string  $type  The type name.
	 *
	 * @return  boolean  True if basic, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isBasicType($type)
	{
		return in_array($type, $this->basicTypes);
	}

	/**
	 * Check if the given type is custom.
	 *
	 * @param   string  $type  The type name.
	 *
	 * @return  boolean  True if custom, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isCustomType($type)
	{
		foreach ($this->customTypes as $types)
		{
			if (isset($types[$type]))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if the given type is a registered class.
	 *
	 * @param   string  $type  The type name.
	 *
	 * @return  boolean  True if basic, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isObjectType($type)
	{
		return in_array($type, $this->objectTypes);
	}

	/**
	 * Check if the given type is allowed (registered).
	 *
	 * @param   string  $type  The type name.
	 *
	 * @return  boolean  True if registered, false otherwise.
	 *
	 * @since   1.0
	 */
	public function isAllowed($type)
	{
		return $this->isBasicType($type) || $this->isCustomType($type) || $this->isObjectType($type);
	}

	/**
	 * Get the registered custom type class corresponding to $type.
	 *
	 * @param   string  $type  The type name.
	 *
	 * @return  PNType  A type object.
	 *
	 * @since   1.0
	 */
	public function getCustomTypeObject($type)
	{
		foreach ($this->customTypes as $types)
		{
			if (isset($types[$type]))
			{
				return $types[$type];
			}
		}
	}

	/**
	 * Get the registered custom types.
	 *
	 * @return  array  The registered custom types.
	 *
	 * @since   1.0
	 */
	public function getCustomTypes()
	{
		return $this->customTypes;
	}

	/**
	 * Get the registered object types.
	 *
	 * @return  array  The registered object types.
	 *
	 * @since   1.0
	 */
	public function getObjectTypes()
	{
		return $this->objectTypes;
	}

	/**
	 * Check if the given var is of the given type.
	 *
	 * @param   mixed   $var   The variable.
	 * @param   string  $type  The type name.
	 *
	 * @return  boolean  True if the type matches, false otherwise.
	 *
	 * @since   1.0
	 */
	public function matches($var, $type)
	{
		$basicType = gettype($var);

		if ($basicType === $type)
		{
			return true;
		}

		// Object type.
		elseif ($basicType === 'object')
		{
			return $var instanceof $type;
		}

		// Custom type.
		else
		{
			if (isset($this->customTypes[$basicType][$type]))
			{
				// Check the type.
				return $this->customTypes[$basicType][$type]->check($var);
			}
		}

		return false;
	}

	/**
	 * Check if the given vars match the given types.
	 *
	 * @param   array  $vars   The variables.
	 * @param   array  $types  The type names.
	 *
	 * @return  boolean  True if they matches, false otherwise.
	 *
	 * @since   1.0
	 */
	public function matchMultiple(array $vars, array $types)
	{
		$varNbr = count($vars);

		if ($varNbr != count($types))
		{
			return false;
		}

		for ($i = 0; $i < $varNbr; $i++)
		{
			if (!$this->matches($vars[$i], $types[$i]))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Get the possible types of the given variable.
	 *
	 * @param   mixed  $var  The variable.
	 *
	 * @return  array  The variable types.
	 *
	 * @since   1.0
	 */
	public function getTypes($var)
	{
		// Init variable.
		$types = array();

		$basicType = gettype($var);

		// If it's an object.
		if ($basicType === 'object')
		{
			$objectType = get_class($var);

			// If the class is registered in the manager.
			if ($this->isObjectType($objectType))
			{
				$types = array($objectType);
			}
		}

		else
		{
			// Init variable.
			$types = array($basicType);

			// Custom type ?
			if (isset($this->customTypes[$basicType]))
			{
				foreach ($this->customTypes[$basicType] as $typeName => $type)
				{
					if ($type->check($var))
					{
						$types[] = $typeName;
					}
				}
			}
		}

		return $types;
	}
}
