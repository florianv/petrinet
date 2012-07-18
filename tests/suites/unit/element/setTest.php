<?php
/**
 * @package     Tests.Unit
 * @subpackage  Element
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNElementSet.
 *
 * @package     Tests.Unit
 * @subpackage  Element
 * @since       1.0
 */
class PNElementSetTest extends TestCase
{
	/**
	 * @var    PNElementSet  A PNElementSet instance.
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

		$this->object = new PNElementSet;
	}

	/**
	 * Add an element to this set.
	 *
	 * @return  void
	 *
	 * @covers  PNElementSet::add
	 * @since   1.0
	 */
	public function testAdd()
	{
		$test = new stdClass;

		// Add one object.
		$this->object->add($test);
		$elements = TestReflection::getValue($this->object, 'elements');
		$this->assertEquals($elements[0], $test);

		// Add two times the same object (multi-set).
		$this->object->add($test);
		$elements = TestReflection::getValue($this->object, 'elements');
		$this->assertCount(2, $elements);
	}

	/**
	 * Add multiple elements in this set.
	 *
	 * @return  void
	 *
	 * @covers  PNElementSet::addMultiple
	 * @since   1.0
	 */
	public function testAddMultiple()
	{
		$obj = new stdClass;
		$obj2 = new stdClass;

		// Add the same object two times.
		$array1 = array($obj, $obj);

		$this->object->addMultiple($array1);
		$elements = TestReflection::getValue($this->object, 'elements');

		$this->assertCount(2, $elements);
		$this->assertEquals($elements[0], $obj);
		$this->assertEquals($elements[1], $obj);

		// Reset elements.
		TestReflection::setValue($this->object, 'elements', array());

		// Adding random objects.
		$array2 = array($obj, $obj2, $obj2);
		$this->object->addMultiple($array2);
		$elements = TestReflection::getValue($this->object, 'elements');

		$this->assertCount(3, $elements);
		$this->assertEquals($elements[0], $obj);
		$this->assertEquals($elements[1], $obj2);
		$this->assertEquals($elements[2], $obj2);
	}

	/**
	 * Remove an element from this set.
	 *
	 * @return  void
	 *
	 * @covers  PNElementSet::remove
	 * @since   1.0
	 */
	public function testRemove()
	{
		// Add the same object two times.
		$obj = new stdClass;
		$array1 = array($obj, $obj);
		TestReflection::setValue($this->object, 'elements', $array1);

		// Delete one copy of it.
		$this->object->remove($obj);

		$elements = TestReflection::getValue($this->object, 'elements');

		$this->assertCount(1, $elements);

		// Delete the other copy.
		$this->object->remove($obj);
		$elements = TestReflection::getValue($this->object, 'elements');
		$this->assertEmpty($elements);
	}

	/**
	 * Clear the set of all its elements.
	 *
	 * @return  void
	 *
	 * @covers  PNElementSet::clear
	 * @since   1.0
	 */
	public function testClear()
	{
		// Add two elements in the set.
		$obj = new stdClass;
		$obj2 = new stdClass;
		$array1 = array($obj, $obj2);
		TestReflection::setValue($this->object, 'elements', $array1);

		// Remove them.
		$elements = $this->object->clear();

		// Assert the set is empty.
		$set = TestReflection::getValue($this->object, 'elements');
		$this->assertEmpty($set);

		// Verify the returned elements.
		$this->assertEquals($elements[0], $obj);
		$this->assertEquals($elements[1], $obj2);
	}

	/**
	 * Count the number of elements in this set.
	 *
	 * @return  void
	 *
	 * @covers  PNElementSet::count
	 * @since   1.0
	 */
	public function testCount()
	{
		// Add two distinct elements.
		$obj = new stdClass;
		$obj1 = new stdClass;
		$array1 = array($obj, $obj1);
		TestReflection::setValue($this->object, 'elements', $array1);

		$this->assertCount(2, $this->object);
	}

	/**
	 * Get the elements in this set.
	 *
	 * @return  void
	 *
	 * @covers  PNElementSet::getElements
	 * @since   1.0
	 */
	public function testGetElements()
	{
		// Assert the set is empty.
		$set = TestReflection::getValue($this->object, 'elements');
		$this->assertEmpty($set);

		// Add two different elements.
		$obj = new stdClass;
		$obj2 = new stdClass;
		$array1 = array($obj, $obj2);
		TestReflection::setValue($this->object, 'elements', $array1);

		$set = TestReflection::getValue($this->object, 'elements');

		$this->assertEquals($this->object->getElements(), $set);
	}
}
