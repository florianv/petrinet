<?php
/**
 * @package     Tests.Unit
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNTypeArray.
 *
 * @package     Tests.Unit
 * @subpackage  Type
 * @since       1.0
 */
class PNTypeArrayTest extends TestCase
{
	/**
	 * @var    PNTypeArray  A PNTypeArray instance.
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

		$this->object = new PNTypeArray;
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
			array(array(), true),
			array('3', false)
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
	 * @covers        PNTypeArray::execute
	 * @since         1.0
	 */
	public function testExecute($var, $expected)
	{
		$return = $this->object->execute($var);

		$this->assertEquals($expected, $return);
	}
}
