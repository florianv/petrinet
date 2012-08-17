<?php
/**
 * @package     Tests.Unit
 * @subpackage  Color
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNColor.
 *
 * @package     Tests.Unit
 * @subpackage  Color
 * @since       1.0
 */
class PNColorTest extends TestCase
{
	/**
	 * @var    PNColor  A PNColor instance.
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

		$this->object = new PNColor;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$data = array(1, 2, 3);
		$color = new PNColor($data);
		$this->assertEquals(TestReflection::getValue($color, 'data'), $data);
	}

	/**
	 * Set the data.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::setData
	 * @since   1.0
	 */
	public function testSetData()
	{
		$data = array(1, 2, 3);
		$this->object->setData($data);
		$this->assertEquals(TestReflection::getValue($this->object, 'data'), $data);
	}

	/**
	 * Add data.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::addData
	 * @since   1.0
	 */
	public function testAddData()
	{
		// Test without position.
		$this->object->addData('foo');
		$this->object->addData('bar');

		$data = TestReflection::getValue($this->object, 'data');
		$this->assertEquals($data[0], 'foo');
		$this->assertEquals($data[1], 'bar');

		// Reset the data.
		TestReflection::setValue($this->object, 'data', array());

		// Test with position.
		$this->object->addData('foo', 8);
		$this->object->addData('bar', 12);

		$data = TestReflection::getValue($this->object, 'data');
		$this->assertEquals($data[8], 'foo');
		$this->assertEquals($data[12], 'bar');
	}

	/**
	 * Get the tuple size.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::count
	 * @since   1.0
	 */
	public function testCount()
	{
		$this->assertEquals(0, count($this->object));

		// Add to elements.
		TestReflection::setValue($this->object, 'data', array(1, 2));

		$this->assertEquals(2, count($this->object));
	}

	/**
	 * Get the data.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::getData
	 * @since   1.0
	 */
	public function testGetData()
	{
		TestReflection::setValue($this->object, 'data', true);
		$this->assertTrue($this->object->getData());
	}

	/**
	 * Get an iterator on the data values.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::getIterator
	 * @since   1.0
	 */
	public function testGetIterator()
	{
		$this->assertInstanceOf('ArrayIterator', $this->object->getIterator());
	}

	/**
	 * Serialize the object.
	 *
	 * @return  void
	 *
	 * @covers  PNColor::serialize
	 * @covers  PNColor::unserialize
	 * @since   1.0
	 */
	public function testSerializeUnserialize()
	{
		$data = array('test', 12);
		$color = new PNColor($data);

		$ser = serialize($color);

		$color = unserialize($ser);

		$this->assertEquals(TestReflection::getValue($color, 'data'), $data);
	}
}
