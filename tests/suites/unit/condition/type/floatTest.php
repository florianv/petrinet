<?php
/**
 * @package     Tests.Unit
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNConditionTypeFloat.
 *
 * @package     Tests.Unit
 * @subpackage  Type
 * @since       1.0
 */
class PNConditionTypeFloatTest extends TestCase
{
	/**
	 * @var    PNConditionTypeFloat  A PNConditionTypeFloat instance.
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

		$this->object = new PNConditionTypeFloat;
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
			array(3.0, true),
			array('2.2', false)
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
	 * @covers        PNConditionTypeFloat::execute
	 * @since         1.0
	 */
	public function testExecute($var, $expected)
	{
		$return = $this->object->execute($var);

		$this->assertEquals($expected, $return);
	}
}
