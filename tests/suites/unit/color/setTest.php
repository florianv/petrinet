<?php
/**
 * @package     Tests.Unit
 * @subpackage  Color
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNColorSet.
 *
 * @package     Tests.Unit
 * @subpackage  Color
 * @since       1.0
 */
class PNColorSetTest extends TestCase
{
	/**
	 * @var    PNColorSet  A PNColorSet instance.
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

		$this->object = new PNColorSet;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		// Test without param.
		$set = new PNColorSet;
		$this->assertEmpty(TestReflection::getValue($set, 'type'));
		$this->assertInstanceOf('PNTypeManager', TestReflection::getValue($set, 'typeManager'));

		$type = array('integer');
		$set = $this->getMock('PNColorSet');
		$set->expects($this->once())
			->method('setType')
			->with($type);

		$set->__construct($type);
	}

	/**
	 * Set the type.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::setType
	 * @since   1.0
	 */
	public function testSetType()
	{
		// Test with all valid types.
		$types = array('integer', 'double', 'array', 'array', 'boolean', 'string');
		$this->object->setType($types);
		$this->assertEquals(TestReflection::getValue($this->object, 'type'), $types);
	}

	/**
	 * Test the setType method exception.
	 *
	 * @return  void
	 *
	 * @expectedException InvalidArgumentException
	 * @covers  PNColorSet::setType
	 * @since   1.0
	 */
	public function testSetTypeException()
	{
		$this->object->setType(array('integer', 'flot'));
	}

	/**
	 * Add a type.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::addType
	 * @since   1.0
	 */
	public function testAddType()
	{
		// Test with position.
		$this->object->addType('integer', 1);
		$this->object->addType('double', 10);

		$types = TestReflection::getValue($this->object, 'type');

		$this->assertEquals($types[1], 'integer');
		$this->assertEquals($types[10], 'double');

		// Reset the types.
		TestReflection::setValue($this->object, 'type', array());

		// Test without position.
		$this->object->addType('integer');
		$this->object->addType('double');

		$types = TestReflection::getValue($this->object, 'type');

		$this->assertEquals($types[0], 'integer');
		$this->assertEquals($types[1], 'double');
	}

	/**
	 * Test the addType exception.
	 *
	 * @return  void
	 *
	 * @expectedException InvalidArgumentException
	 * @covers  PNColorSet::addType
	 * @since   1.0
	 */
	public function testAddTypeException()
	{
		$this->object->addType('test');
	}

	/**
	 * Get the composite type.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::getType
	 * @since   1.0
	 */
	public function testGetType()
	{
		TestReflection::setValue($this->object, 'type', true);
		$this->assertTrue($this->object->getType());
	}

	/**
	 * Check if the given color matches the color set definition.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::matches
	 * @since   1.0
	 */
	public function testMatches()
	{
		// Test with different sizes.
		$color = new PNColor(array(8, 'test'));
		$set = new PNColorSet(array('integer'));

		$this->assertFalse($set->matches($color));

		// Test with unmatching types.
		$color = new PNColor(array(8, array()));
		$set = new PNColorSet(array('integer', 'double'));
		$this->assertFalse($set->matches($color));

		// Test with matching types.
		$color = new PNColor(array(8, array(), 'test', 'test2', true));
		$set = new PNColorSet(array('integer', 'array', 'string', 'string', 'boolean'));
		$this->assertTrue($set->matches($color));
	}

	/**
	 * Get an iterator on the color set.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::getIterator
	 * @since   1.0
	 */
	public function getIterator()
	{
		$this->assertInstanceOf('ArrayIterator', $this->object->getIterator());
	}

	/**
	 * Serialize the set.
	 *
	 * @return  void
	 *
	 * @covers  PNColorSet::serialize
	 * @covers  PNColorSet::unserialize
	 * @since   1.0
	 */
	public function testSerializeUnserialize()
	{
		$colorSet = new PNColorSet(array('integer', 'double', 'array', 'double'));

		$ser = serialize($colorSet);

		$unserialized = unserialize($ser);

		$this->assertEquals($colorSet, $unserialized);
	}

	/**
	 * Get the set size.
	 *
	 * @return  integer  void
	 *
	 * @covers  PNColorSet::count
	 * @since   1.0
	 */
	public function testCount()
	{
		TestReflection::setValue($this->object, 'type', array(1, 2, 3));
		$this->assertEquals(3, count($this->object));
	}
}
