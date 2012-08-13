<?php
/**
 * @package     Tests.Unit
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNTypeBoolean.
 *
 * @package     Tests.Unit
 * @subpackage  Type
 * @since       1.0
 */
class PNTypeBooleanTest extends TestCase
{
	/**
	 * @var    PNTypeBoolean  A PNTypeBoolean instance.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Setup.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->object = new PNTypeBoolean;
	}

	/**
	 * Data provider for the execute method.
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function provider()
	{
		return array(
			array(true, true),
			array(0, false)
		);
	}

	/**
	 * Evaluate the condition.
	 *
	 * @param   mixed    $var       The variable value.
	 * @param   boolean  $expected  The expected return value.
	 *
	 * @return  void
	 *
	 * @dataProvider  provider
	 * @covers        PNTypeBoolean::execute
	 * @since         1.0
	 */
	public function testExecute($var, $expected)
	{
		$return = $this->object->execute($var);

		$this->assertEquals($expected, $return);
	}
}
