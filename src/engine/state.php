<?php
/**
 * @package     Petrinet
 * @subpackage  Engine
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Base Class for Engine States.
 *
 * @package     Petrinet
 * @subpackage  Engine
 * @since       1.0
 */
abstract class PNEngineState
{
	/**
	 * @var    PNEngine  The engine context.
	 * @since  1.0
	 */
	protected $engine;

	/**
	 * Constructor.
	 *
	 * @param   PNEngine  $engine  The engine context.
	 *
	 * @since   1.0
	 */
	public function __construct(PNEngine $engine)
	{
		$this->engine = $engine;
	}

	/**
	 * Start the execution.
	 *
	 * @return  void
	 *
	 * @ignore
	 *
	 * @since   1.0
	 */
	abstract public function start();

	/**
	 * Stop the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract public function stop();

	/**
	 * Pause the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract public function pause();

	/**
	 * Resume the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract public function resume();

	/**
	 * Main execution method.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract public function run();

	/**
	 * End the execution.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	abstract public function end();
}
