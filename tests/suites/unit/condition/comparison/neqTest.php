<?php
/**
 * @package     Tests.Unit
 * @subpackage  Comparison
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNConditionComparisonNeq.
 *
 * @package     Tests.Unit
 * @subpackage  Comparison
 * @since       1.0
 */
class PNConditionComparisonNeqTest extends TestCase
{
	/**
	 * @var    PNConditionComparisonNeq  A PNConditionComparisonNeq instance.
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

		$this->object = new PNConditionComparisonNeq;
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
			array(3, 3 ,false),
			array(3, 3.2, true),
			array('3', 3, false)
		);
	}

	/**
	 * Evaluate the condition.
	 *
	 * @param   mixed    $leftValue   The left value.
	 * @param   mixed    $rightValue  The right value.
	 * @param   boolean  $expected    The expected return value.
	 *
	 * @return  void
	 *
	 * @dataProvider  provider
	 * @covers        PNConditionComparisonNeq::execute
	 * @since         1.0
	 */
	public function testExecute($leftValue, $rightValue, $expected)
	{
		$return = $this->object->execute($leftValue, $rightValue);

		$this->assertEquals($expected, $return);
	}
}
