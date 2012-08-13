<?php
/**
 * @package     Tests.Unit
 * @subpackage  Type
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

require_once dirname(__FILE__) . '/stubs/random.php';
require_once dirname(__FILE__) . '/stubs/integerone.php';
require_once dirname(__FILE__) . '/stubs/integertwo.php';
require_once dirname(__FILE__) . '/stubs/floatthree.php';

/**
 * Test class for PNTypeManager.
 *
 * @package     Tests.Unit
 * @subpackage  Type
 * @since       1.0
 */
class PNTypeManagerTest extends TestCase
{
	/**
	 * @var    PNTypeManager  A PNTypeManager instance.
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

		$this->object = new PNTypeManager;
	}

	/**
	 * Register an object type to the manager.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::registerObjectType
	 * @since   1.0
	 */
	public function testRegisterObjectType()
	{
		// Test with a not found class.
		$this->assertFalse($this->object->registerObjectType('test'));

		// Register an existing class.
		$this->assertTrue($this->object->registerObjectType('Random'));
		$objectType = TestReflection::getValue($this->object, 'objectTypes');
		$this->assertEquals('Random', $objectType[0]);

		// Try to register it two times.
		$this->assertTrue($this->object->registerObjectType('Random'));
		$objectType = TestReflection::getValue($this->object, 'objectTypes');

		// Verify it is not added two times.
		$this->assertCount(1, $objectType);
	}

	/**
	 * Test the exception thrown by registerCustomType.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::registerCustomType
	 * @expectedException  UnexpectedValueException
	 * @since   1.0
	 */
	public function testRegisterCustomTypeException()
	{
		// Test with a not found type class.
		$this->object->registerCustomType('mytype', 'integer');
	}

	/**
	 * Register a custom type to the system.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::registerCustomType
	 * @since   1.0
	 */
	public function testRegisterCustomType()
	{
		// Test with a non existing parent type.
		$this->assertFalse($this->object->registerCustomType('type', 'non-existing'));

		// Test with an already registered type.
		TestReflection::setValue($this->object, 'customTypes', array('integer' => array('mytype' => 'hello')));
		$this->assertTrue($this->object->registerCustomType('mytype', 'integer'));

		// Assert nothing was added.
		$customTypes = TestReflection::getValue($this->object, 'customTypes');
		$this->assertEquals('hello', $customTypes['integer']['mytype']);

		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		// Test with an existing type class.
		$integerOne = new IntegerOne;

		$this->assertTrue($this->object->registerCustomType('mytype', 'integer', $integerOne));
		$customTypes = TestReflection::getValue($this->object, 'customTypes');

		$this->assertInstanceOf('IntegerOne', $customTypes['integer']['mytype']);

		// Try to add it two times.
		$this->assertTrue($this->object->registerCustomType('mytype', 'integer', $integerOne));
		$customTypes = TestReflection::getValue($this->object, 'customTypes');

		$this->assertEquals($integerOne, $customTypes['integer']['mytype']);
	}

	/**
	 * Data provider for testIsBasicType.
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function providerIsBasicType()
	{
		return array(
			array('integer', true),
			array('boolean', true),
			array('double', true),
			array('array', true),
			array('string', true),
			array('object', false)
		);
	}

	/**
	 * Check if the given type is 'basic'.
	 *
	 * @param   string   $type      The type.
	 * @param   boolean  $expected  The expected return value.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::isBasicType
	 * @dataProvider  providerIsBasicType
	 * @since   1.0
	 */
	public function testIsBasicType($type, $expected)
	{
		$this->assertEquals($this->object->isBasicType($type), $expected);
	}

	/**
	 * Check if the given type is custom.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::isCustomType
	 * @since   1.0
	 */
	public function testIsCustomType()
	{
		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		$this->assertFalse($this->object->isCustomType('non-existing'));

		// Register a custom type.
		$integerOne = new IntegerOne;
		$this->object->registerCustomType('integerone', 'integer', $integerOne);

		$this->assertTrue($this->object->isCustomType('integerone'));

		// Try with an other one a custom type.
		$integerTwo = new IntegerTwo;
		$this->object->registerCustomType('integertwo', 'integer', $integerTwo);

		$this->assertTrue($this->object->isCustomType('integertwo'));
	}

	/**
	 * Check if the given type is a registered class.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::isObjectType
	 * @since   1.0
	 */
	public function testIsObjectType()
	{
		// Reset the object types.
		TestReflection::setValue($this->object, 'objectTypes', array());

		// Register an object type.
		$this->assertFalse($this->object->isObjectType('Random'));

		// Register the type.
		$this->object->registerObjectType('Random');
		$this->assertTrue($this->object->isObjectType('Random'));
	}

	/**
	 * Check if the given type is registered.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::isAllowed
	 * @since   1.0
	 */
	public function testIsAllowed()
	{
		$this->assertTrue($this->object->isAllowed('string'));
		$this->assertTrue($this->object->isAllowed('array'));

		$this->assertFalse($this->object->isAllowed('object'));

		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		// Reset the object types.
		TestReflection::setValue($this->object, 'objectTypes', array());

		$this->assertFalse($this->object->isAllowed('Random'));
		$this->assertFalse($this->object->isAllowed('IntegerOne'));

		// Register a custom type.
		$integerOne = new IntegerOne;
		$this->object->registerCustomType('IntegerOne', 'integer', $integerOne);

		// Register an object type.
		$this->object->registerObjectType('Random');

		$this->assertTrue($this->object->isAllowed('Random'));
		$this->assertTrue($this->object->isAllowed('IntegerOne'));

		$this->assertFalse($this->object->isAllowed('integerOne'));
	}

	/**
	 * Get the registered custom type class corresponding to $type.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::getCustomTypeObject
	 * @since   1.0
	 */
	public function testGetCustomTypeObject()
	{
		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		$this->assertNull($this->object->getCustomTypeObject('non-existing'));

		// Register two custom types.
		$integerOne = new IntegerOne;
		$this->object->registerCustomType('IntegerOne', 'integer', $integerOne);

		$integerTwo = new IntegerTwo;
		$this->object->registerCustomType('integertwo', 'integer', $integerTwo);

		$this->assertInstanceOf('IntegerOne', $this->object->getCustomTypeObject('IntegerOne'));
		$this->assertInstanceOf('IntegerTwo', $this->object->getCustomTypeObject('integertwo'));
	}

	/**
	 * Get the registered custom types.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::getCustomTypes
	 * @since   1.0
	 */
	public function testGetCustomTypes()
	{
		TestReflection::setValue($this->object, 'customTypes', true);

		$this->assertTrue($this->object->getCustomTypes());
	}

	/**
	 * Get the registered object types.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::getObjectTypes
	 * @since   1.0
	 */
	public function testGetObjectTypes()
	{
		TestReflection::setValue($this->object, 'objectTypes', true);

		$this->assertTrue($this->object->getObjectTypes());
	}

	/**
	 * Data provider for testMatchesBasicType
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function providerMatchesBasicType()
	{
		return array(
			array(1, 'integer', true),
			array(1.1, 'double', true),
			array(true, 'boolean', true),
			array('test', 'string', true),
			array(array(8), 'array', true),
			array(8, 'double', false),
			array(1, 'boolean', false),
			array(1, 'string', false),
		);
	}

	/**
	 * Check if the given var is of the given type.
	 *
	 * @param   mixed    $value     The value.
	 * @param   string   $type      The type name.
	 * @param   boolean  $expected  The expected return value.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::matches
	 * @dataProvider  providerMatchesBasicType
	 * @since   1.0
	 */
	public function testMatchesBasicType($value, $type, $expected)
	{
		$this->assertEquals($this->object->matches($value, $type), $expected);
	}

	/**
	 * Check if the given var is of the given type.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::matches
	 * @since   1.0
	 */
	public function testMatchesObjectType()
	{
		// Create a random object.
		$random = new Random;

		$this->assertTrue($this->object->matches($random, 'Random'));
	}

	/**
	 * Data provider for testMatchesCustomType
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function providerMatchesCustomType()
	{
		return array(
			array(2, 'IntegerOne', true),
			array(1.2, 'IntegerOne', false),
			array(2, 'integerOne', false), // Invalid type name
			array(3, 'integertwo', true),
			array(2.5, 'integertwo', false),
			array(8, 'integertwo', true),
			array(8, 'Integertwo', false), // Invalid type name
		);
	}

	/**
	 * Check if the given var is of the given type.
	 *
	 * @param   mixed    $var       The variable.
	 * @param   string   $type      The type name.
	 * @param   boolean  $expected  The expected return value.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::matches
	 * @dataProvider  providerMatchesCustomType
	 * @since   1.0
	 */
	public function testMatchesCustomType($var, $type, $expected)
	{
		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		// Register two types.
		// Type of integers > 1
		$integerOne = new IntegerOne;
		$this->object->registerCustomType('IntegerOne', 'integer', $integerOne);

		// Type of integers > 2
		$integerTwo = new IntegerTwo;
		$this->object->registerCustomType('integertwo', 'integer', $integerTwo);

		$this->assertEquals($this->object->matches($var, $type), $expected);
	}

	/**
	 * Check if the given vars match the given types.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::matchMultiple
	 * @since   1.0
	 */
	public function testMatchMultiple()
	{
		// Test with two array with a different size.
		$vars = array(2, 3, 4);
		$types = array('integer', 'double');

		$this->assertFalse($this->object->matchMultiple($vars, $types));
	}

	/**
	 * Data provider for testMatchMultipleWithData.
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function providerMatchMultipleWithData()
	{
		return array(
			array(array(2, 3.2, 2), array('integer', 'double', 'IntegerOne'), true),
			array(array(2, 3.2, 2), array('integer', 'IntegerOne', 'double'), false),
			array(array(3, new Random, 'test', array(8)), array('integertwo', 'Random', 'string', 'array'), true),
			array(array(3, 8, array(12)), array('array', 'integer', 'integer'), false),
			array(array(array(5), array(7), array(12)), array('array', 'array', 'array'), true)
		);
	}

	/**
	 * Check if the given vars match the given types.
	 *
	 * @param   array    $vars      The variables.
	 * @param   array    $types     The type names.
	 * @param   boolean  $expected  The expected return value.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::matchMultiple
	 * @dataProvider  providerMatchMultipleWithData
	 * @since   1.0
	 */
	public function testMatchMultipleWithData($vars, $types, $expected)
	{
		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		// Register two types.
		// Type of integers > 1
		$integerOne = new IntegerOne;
		$this->object->registerCustomType('IntegerOne', 'integer', $integerOne);

		// Type of integers > 2
		$integerTwo = new IntegerTwo;
		$this->object->registerCustomType('integertwo', 'integer', $integerTwo);

		$this->assertEquals($this->object->matchMultiple($vars, $types), $expected);
	}

	/**
	 * Data provider for testMatchMultipleWithData.
	 *
	 * @return  array  The data.
	 *
	 * @since   1.0
	 */
	public function providerGetTypes()
	{
		return array(
			array(8, array('integer', 'integerone', 'integertwo')),
			array(5.5, array('double', 'floathree')),
			array(new Random, array('Random')),
			array(0, array('integer')),
			array(2, array('integer', 'integerone')),
			array('test', array('string')),
			array(array(8), array('array'))
		);
	}

	/**
	 * Get the possible types of the given variable.
	 *
	 * @param   mixed  $var       The variable.
	 * @param   array  $expected  The expected types.
	 *
	 * @return  void
	 *
	 * @covers  PNTypeManager::getTypes
	 * @dataProvider  providerGetTypes
	 * @since   1.0
	 */
	public function testGetTypes($var, array $expected)
	{
		// Reset the custom types.
		TestReflection::setValue($this->object, 'customTypes', array());

		// Reset the object types.
		TestReflection::setValue($this->object, 'objectTypes', array());

		// Register an object type.
		$this->object->registerObjectType('Random');

		// Register two types.
		// Type of integers > 1
		$integerOne = new IntegerOne;
		$this->object->registerCustomType('integerone', 'integer', $integerOne);

		// Type of integers > 2
		$integerTwo = new IntegerTwo;
		$this->object->registerCustomType('integertwo', 'integer', $integerTwo);

		// Type of floats > 3
		$floatThree = new FloatThree;
		$this->object->registerCustomType('floathree', 'double', $floatThree);

		$this->assertEquals($this->object->getTypes($var), $expected);
	}
}
