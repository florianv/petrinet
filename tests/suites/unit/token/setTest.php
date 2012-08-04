<?php
/**
 * @package     Tests.Unit
 * @subpackage  Token
 *
 * @copyright   Copyright (C) 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

/**
 * Test class for PNTokenSet.
 *
 * @package     Tests.Unit
 * @subpackage  Token
 * @since       1.0
 */
class PNTokenSetTest extends TestCase
{
	/**
	 * @var    PNToken  A PNTokenSet instance.
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

		$this->object = new PNTokenSet;
	}

	/**
	 * Constructor.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::__construct
	 * @since   1.0
	 */
	public function test__construct()
	{
		$this->assertEmpty(TestReflection::getValue($this->object, 'tokens'));

		$tokens = array(new PNToken, new PNToken);
		$set = new PNTokenSet($tokens);
		$this->assertContains($tokens, TestReflection::getValue($set, 'tokens'));
	}

	/**
	 * Check if a token belongs to this set.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::exists
	 * @since   1.0
	 */
	public function testExists()
	{
		$color = new PNColor(array(8, 3));
		$token1 = new PNToken($color);

		$token2 = new PNToken;

		$this->object->addToken($token1);

		$this->assertFalse($this->object->exists($token2));
		$this->assertTrue($this->object->exists($token1));

		$this->object->addToken($token2);
		$this->assertTrue($this->object->exists($token2));
	}

	/**
	 * Add a token to this set.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::addToken
	 * @since   1.0
	 */
	public function testAddToken()
	{
		$color = new PNColor(array(8, 3));
		$token = new PNToken($color);

		$serToken = serialize($token);

		$this->object->addToken($token);

		$tokens = TestReflection::getValue($this->object, 'tokens');
		$this->assertEquals($token, $tokens[$serToken][0]);

		// Add the same token two times.
		$this->object->addToken($token);

		$tokens = TestReflection::getValue($this->object, 'tokens');
		$this->assertEquals($token, $tokens[$serToken][0]);
		$this->assertEquals($token, $tokens[$serToken][1]);
	}

	/**
	 * Remove a token from this set.
	 * Only a copy of one token is removed if it appears more than
	 * one time in the set.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::removeToken
	 * @since   1.0
	 */
	public function testRemoveToken()
	{
		$color = new PNColor(array(8, 3));
		$token = new PNToken($color);

		// Add the same token two times.
		$this->object->addToken($token)->addToken($token);

		// Remove one copy of it.
		$this->object->removeToken($token);

		$tokens = TestReflection::getValue($this->object, 'tokens');
		$this->assertEquals(1, count($tokens));

		// Remove the other copy.
		$this->object->removeToken($token);

		$this->assertEmpty(TestReflection::getValue($this->object, 'tokens'));

		// Add a new one and remove it.
		$this->object->addToken($token);
		$this->object->removeToken($token);

		$this->assertEmpty(TestReflection::getValue($this->object, 'tokens'));
	}

	/**
	 * Set the tokens in this set.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::setTokens
	 * @since   1.0
	 */
	public function testSetTokens()
	{
		$color = new PNColor(array(8, 3));
		$token = new PNToken($color);

		$tokens = array($token, $token);
		$this->object->setTokens($tokens);

		$this->assertContains($tokens, TestReflection::getValue($this->object, 'tokens'));
	}

	/**
	 * Get the tokens in this set.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::getTokens
	 * @since   1.0
	 */
	public function testGetTokens()
	{
		TestReflection::setValue($this->object, 'tokens', true);
		$this->assertTrue($this->object->getTokens());
	}

	/**
	 * Get an iterator on the token set.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::getIterator
	 * @since   1.0
	 */
	public function testGetIterator()
	{
		$this->assertInstanceOf('ArrayIterator', $this->object->getIterator());
	}

	/**
	 * Clear the set of all its tokens.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::clear
	 * @since   1.0
	 */
	public function testClear()
	{
		$color = new PNColor(array(8, 3));
		$token = new PNToken($color);

		$tokens = array($token, $token);
		TestReflection::setValue($this->object, 'tokens', $tokens);

		$this->assertEquals($tokens, $this->object->clear());

		$this->assertEmpty(TestReflection::getValue($this->object, 'tokens'));
	}

	/**
	 * Get the set size.
	 *
	 * @return  void
	 *
	 * @covers  PNTokenSet::count
	 * @since   1.0
	 */
	public function testCount()
	{
		TestReflection::setValue($this->object, 'tokens', array(1, 2, 3));
		$this->assertEquals(3, count($this->object));
	}
}
