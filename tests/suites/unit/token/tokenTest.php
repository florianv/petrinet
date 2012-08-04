<?php
/**
 * @package     Tests.Unit
 * @subpackage  Token
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNToken.
 *
 * @package     Tests.Unit
 * @subpackage  Token
 * @since       1.0
 */
class PNTokenTest extends TestCase
{
	/**
	 * @var    PNToken  A PNToken instance.
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

		$this->object = new PNToken;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNToken::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$this->assertNull(TestReflection::getValue($this->object, 'color'));

		$color = new PNColor;
		$token = new PNToken($color);

		$this->assertEquals(TestReflection::getValue($token, 'color'), $color);
	}

	/**
	 * Check if the token is colored.
	 *
	 * @return  void
	 *
	 * @covers  PNToken::isColored
	 * @since   1.0
	 */
	public function testIsColored()
	{
		$this->assertFalse($this->object->isColored());

		$color = new PNColor;
		TestReflection::setValue($this->object, 'color', $color);

		$this->assertTrue($this->object->isColored());
	}

	/**
	 * Get the Token color.
	 *
	 * @return  void
	 *
	 * @covers  PNToken::getColor
	 * @since   1.0
	 */
	public function testGetColor()
	{
		$this->assertNull($this->object->getColor());

		$color = new PNColor;
		TestReflection::setValue($this->object, 'color', $color);

		$this->assertEquals(TestReflection::getValue($this->object, 'color'), $color);
	}

	/**
	 * Set the Token color.
	 *
	 * @return  void
	 *
	 * @covers  PNToken::setColor
	 * @since   1.0
	 */
	public function testSetColor()
	{
		$color = new PNColor;
		$this->object->setColor($color);

		$this->assertEquals(TestReflection::getValue($this->object, 'color'), $color);
	}

	/**
	 * Serialize the token.
	 *
	 * @return  void
	 *
	 * @covers  PNToken::serialize
	 * @since   1.0
	 */
	public function testSerialize()
	{
		// Check two tokens with the same color are the same serialized strings.
		$color = new PNColor;
		$token1 = new PNToken($color);
		$token2 = new PNToken($color);
		$token3 = new PNToken;

		$this->assertEquals(serialize($token1), serialize($token2));
		$this->assertFalse(serialize($token2) === serialize($token3));
	}

	/**
	 * Unserialize the token.
	 *
	 * @return  void
	 *
	 * @covers  PNToken::unserialize
	 * @since   1.0
	 */
	public function testUnserialize()
	{
		$color = new PNColor(array('test'));
		$token = new PNToken($color);

		$ser = serialize($token);

		$unser = unserialize($ser);

		$this->assertEquals($token, $unser);
		$this->assertEquals(TestReflection::getValue($token, 'color'), $color);
	}
}
