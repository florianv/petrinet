<?php
/**
 * @package     Tests.Unit
 * @subpackage  Arc
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNArcExpression.
 *
 * @package     Tests.Unit
 * @subpackage  Arc
 * @since       1.0
 */
class PNArcExpressionTest extends TestCase
{
	/**
	 * @var    PNArcExpression  A PNArcExpression mock.
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

		$this->object = $this->getMockForAbstractClass('PNArcExpression');
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNArcExpression::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$this->assertEmpty(TestReflection::getValue($this->object, 'arguments'));

		$this->assertInstanceOf('PNTypeManager', TestReflection::getValue($this->object, 'typeManager'));

		$expression = $this->getMockForAbstractClass('PNArcExpression', array(array('integer')));
		$this->assertEquals(TestReflection::getValue($expression, 'arguments'), array('integer'));
	}

	/**
	 * Set the expression arguments.
	 *
	 * @return  void
	 *
	 * @covers  PNArcExpression::setArguments
	 * @since   1.0
	 */
	public function testSetArguments()
	{
		$arguments1 = array('integer', 'boolean', 'double', 'integer', 'array', 'string', 'string');
		TestReflection::invoke($this->object, 'setArguments', $arguments1);

		$this->assertEquals(TestReflection::getValue($this->object, 'arguments'), $arguments1);

		$arguments2 = array('integer', 'integer', 'double', 'integer', 'array', 'boolean', 'string');
		TestReflection::invoke($this->object, 'setArguments', $arguments2);

		$this->assertEquals(TestReflection::getValue($this->object, 'arguments'), $arguments2);
	}

	/**
	 * Test the setArguments exception.
	 *
	 * @return  void
	 *
	 * @expectedException InvalidArgumentException
	 * @covers  PNArcExpression::setArguments
	 * @since   1.0
	 */
	public function testSetArgumentsException()
	{
		$arguments = array('integer', 'integer', 'float', 'not-allowed', 'array');
		TestReflection::invoke($this->object, 'setArguments', $arguments);
	}

	/**
	 * Set the type Manager.
	 *
	 * @return  void
	 *
	 * @covers  PNArcExpression::setTypeManager
	 * @since   1.0
	 */
	public function testSetTypeManager()
	{
		// Reset the type manager.
		TestReflection::setValue($this->object, 'typeManager', null);

		$manager = new PNTypeManager;
		$this->object->setTypeManager($manager);

		$this->assertEquals(TestReflection::getValue($this->object, 'typeManager'), $manager);
	}

	/**
	 * Get the expression arguments.
	 *
	 * @return  void
	 *
	 * @covers  PNArcExpression::getArguments
	 * @since   1.0
	 */
	public function testGetArguments()
	{
		TestReflection::setValue($this->object, 'arguments', true);
		$this->assertTrue($this->object->getArguments());
	}
}
