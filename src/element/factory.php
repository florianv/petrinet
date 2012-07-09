<?php
/**
 * @package     Petrinet
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Factory class for Petri Net elements.
 *
 * @package     Petrinet
 * @subpackage  Element
 * @since       1.0
 */
abstract class PNElementFactory
{
	/**
	 * Get a Petri net.
	 *
	 * @param   string  $name  The Petri net name.
	 *
	 * @return  PNElementPetrinet
	 *
	 * @since   1.0
	 */
	public static function getPetrinet($name)
	{
		return PNElementPetrinet::getInstance($name);
	}

	/**
	 * Get a Place.
	 *
	 * @return  PNElementPlace
	 *
	 * @since   1.0
	 */
	public static function getPlace()
	{
		return new PNElementPlace;
	}

	/**
	 * Get a Transition.
	 *
	 * @return  PNElementTransition
	 *
	 * @since   1.0
	 */
	public static function getTransition()
	{
		return new PNElementTransition;
	}

	/**
	 * Get an Arc (input or output)
	 *
	 * @param   string  $type  The Arc type.
	 *
	 * @return  PNElementArc  The Arc.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public static function getArc($type)
	{
		if ($type === 'input')
		{
			return new PNElementArcInput;
		}

		elseif ($type === 'output')
		{
			return new PNElementArcOutput;
		}

		else
		{
			throw new InvalidArgumentException('Unknown Arc Type : ' . $type);
		}
	}

	/**
	 * Get a Guard.
	 *
	 * @param   PNElementOperator  $operator  The Comparison Operator.
	 * @param   PNElementVariable  $variable  The Variable.
	 * @param   mixed              $value     The Value to compare against.
	 *
	 * @return  PNElementGuard  The Guard.
	 *
	 * @since  1.0
	 */
	public static function getGuard(PNElementOperator $operator = null, PNElementVariable $variable = null, $value = null)
	{
		return new PNElementGuard($operator, $variable, $value);
	}

	/**
	 * Get a Comparison Operator.
	 *
	 * @param   string  $type  The Operator type.
	 *
	 * @return  PNElementOperator  The operator.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since  1.0
	 */
	public static function getOperator($type)
	{
		if (preg_match('#^(eq|neq|gt|gte|lt|lte)$#', $type))
		{
			$class = 'PNElementOperator' . ucfirst($type);
			return new $class;
		}

		throw new InvalidArgumentException('Unknown Operator Type : ' . $type);
	}
}
