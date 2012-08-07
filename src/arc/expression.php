<?php
/**
 * @package     Petrinet
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base class for PHP expressions associated with an arc.
 * The expression arguments property contains an (ordered) array of PHP types.
 * The arc expression arguments must match the attached place color set.
 *
 * @package     Petrinet
 * @subpackage  Arc
 * @since       1.0
 */
abstract class PNArcExpression
{
	/**
	 * @var    array  The expression arguments (php types).
	 * @since  1.0
	 */
	protected $arguments;

	/**
	 * @var    array  The allowed arguments.
	 * @since  1.0
	 */
	protected $allowedArguments = array(
		'integer',
		'float',
		'boolean',
		'string',
		'array'
	);

	/**
	 * Constructor.
	 *
	 * @param   array  $arguments  The expression arguments.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function __construct(array $arguments = array())
	{
		$this->setArguments($arguments);
	}

	/**
	 * Execute the expression.
	 * The method must return an array of the same size than the $arguments class property,
	 * and containing elements of the same type.
	 *
	 * Example :
	 * The expression arguments are : $arguments = array('integer', 'float').
	 * The execute method can return array($arguments[0]+1, $arguments[1]+2).
	 *
	 * The execution engine will bind different values (token colors) to $arguments[0] and $arguments[1]
	 * and execute your expression, to verify/produce tokens.
	 *
	 * @param   array  $arguments  The expression arguments.
	 *
	 * @return  array  The return values.
	 *
	 * @since   1.0
	 */
	abstract public function execute(array $arguments);

	/**
	 * Check if the argument is allowed.
	 *
	 * @param   mixed  $argument  The argument.
	 *
	 * @return  boolean  True if allowed, false otherwise.
	 *
	 * @since   1.0
	 */
	protected function isAllowed($argument)
	{
		return in_array($argument, $this->allowedArguments);
	}

	/**
	 * Set the expression arguments.
	 *
	 * @param   array  $arguments  The expression arguments.
	 *
	 * @return  void
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	protected function setArguments(array $arguments)
	{
		// Verify all arguments are allowed.
		foreach ($arguments as $argument)
		{
			if (!$this->isAllowed($argument))
			{
				throw new InvalidArgumentException('Argument : ' . $argument . ' is not allowed');
			}
		}

		$this->arguments = $arguments;
	}

	/**
	 * Get the expression arguments.
	 *
	 * @return  array  The expression arguments.
	 *
	 * @since   1.0
	 */
	public function getArguments()
	{
		return $this->arguments;
	}
}
