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
 * Arcs expressions are used to transform the token color (ie. operating on its values),
 * or asserting they match certain values.
 *
 * The expression arguments property contains an (ordered) array of PHP types
 * that must match the attached place/transition color set.
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
	 * @var    PNTypeManager  The type Manager.
	 * @since  1.0
	 */
	protected $typeManager;

	/**
	 * Constructor.
	 *
	 * @param   array          $arguments  The expression arguments.
	 * @param   PNTypeManager  $manager    The type Manager.
	 *
	 * @throws  InvalidArgumentException
	 *
	 * @since   1.0
	 */
	public function __construct(array $arguments = array(), PNTypeManager $manager = null)
	{
		// Use the given type manager, or create a new one.
		$this->typeManager = $manager ? $manager : new PNTypeManager;

		$this->setArguments($arguments);
	}

	/**
	 * Execute the expression.
	 * The method must return an array of data compatible with the output place/transition color set.
	 *
	 * @param   array  $arguments  The expression arguments.
	 *
	 * @return  array  The return values.
	 *
	 * @since   1.0
	 */
	abstract public function execute(array $arguments);

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
			if (!$this->typeManager->isAllowed($argument))
			{
				throw new InvalidArgumentException('Argument : ' . $argument . ' is not allowed');
			}
		}

		// Store them.
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
