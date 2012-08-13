<?php
/**
 * @package     Tests.Unit
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNTypeString.
 *
 * @package     Tests.Unit
 * @subpackage  Type
 * @since       1.0
 */
class PNTypeStringTest extends TestCase
{
	/**
	 * @var    PNTypeString  A PNTypeString instance.
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

		$this->object = new PNTypeString;
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
			array('test', true),
			array(22, false)
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
	 * @covers        PNTypeString::execute
	 * @since         1.0
	 */
	public function testExecute($var, $expected)
	{
		$return = $this->object->execute($var);

		$this->assertEquals($expected, $return);
	}
}
