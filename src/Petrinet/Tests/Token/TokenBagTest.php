<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Token;

use Petrinet\Token\TokenBag;
use Petrinet\Token\Token;

/**
 * Test class for TokenBag.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TokenBagTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $tokenBag = new TokenBag();
        $this->assertFalse($tokenBag->hasFree());

        $tokens = array(new Token(), new Token());
        $tokenBag = new TokenBag($tokens);
        $this->assertEquals($tokens, $tokenBag->getAll());
    }

    public function testAdd()
    {
        $tokenBag = new TokenBag();
        $token1 = new Token();
        $token2 = new Token();

        $tokenBag->add($token1);
        $tokenBag->add($token2);

        $tokens = $tokenBag->getAll();
        $this->assertSame($token1, $tokens[0]);
        $this->assertSame($token2, $tokens[1]);
    }

    public function testAddMultiple()
    {
        $tokenBag = new TokenBag();
        $tokens = array(new Token(), new Token());
        $tokenBag->addMultiple($tokens);
        $this->assertEquals($tokens, $tokenBag->getAll());
    }

    public function testHasFreeToken()
    {
        $tokenBag = new TokenBag();
        $this->assertFalse($tokenBag->hasFree());
        $token = new Token();
        $tokenBag->add($token);
        $this->assertTrue($tokenBag->hasFree());
    }

    public function testCountFree()
    {
        $tokenBag = new TokenBag();
        $this->assertEquals(0, $tokenBag->countFree());
        $token = new Token();
        $tokenBag->add($token);
        $this->assertEquals(1, $tokenBag->countFree());
        $token->setBlocked();
        $this->assertEquals(0, $tokenBag->countFree());
        $token->setConsumed();
        $this->assertEquals(0, $tokenBag->countFree());
    }

    public function testCountBlocked()
    {
        $tokenBag = new TokenBag();
        $this->assertEquals(0, $tokenBag->countBlocked());
        $token = new Token();
        $tokenBag->add($token);
        $this->assertEquals(0, $tokenBag->countBlocked());
        $token->setBlocked();
        $this->assertEquals(1, $tokenBag->countBlocked());
        $token->setConsumed();
        $this->assertEquals(0, $tokenBag->countBlocked());
    }

    public function testCountConsumed()
    {
        $tokenBag = new TokenBag();
        $this->assertEquals(0, $tokenBag->countConsumed());
        $token = new Token();
        $tokenBag->add($token);
        $this->assertEquals(0, $tokenBag->countConsumed());
        $token->setBlocked();
        $this->assertEquals(0, $tokenBag->countConsumed());
        $token->setConsumed();
        $this->assertEquals(1, $tokenBag->countConsumed());
    }

    public function testBlockOne()
    {
        $tokenBag = new TokenBag();
        $this->assertNull($tokenBag->blockOne());

        $token = new Token();
        $tokenBag->add($token);
        $this->assertSame($token, $tokenBag->blockOne());
        $this->assertEquals(1, $tokenBag->countBlocked());
    }

    public function testConsumeOne()
    {
        $tokenBag = new TokenBag();
        $this->assertNull($tokenBag->consumeOne());

        $token = new Token();
        $tokenBag->add($token);
        $this->assertNull($tokenBag->consumeOne());
        $token->setBlocked();
        $this->assertSame($token, $tokenBag->consumeOne());
        $this->assertEquals(1, $tokenBag->countConsumed());
    }

    public function testClear()
    {
        $tokenBag = new TokenBag();
        $this->assertEmpty($tokenBag->clear());
        $this->assertEmpty($tokenBag->getAll());

        $tokens = array(new Token(), new Token());
        $tokenBag->addMultiple($tokens);
        $this->assertEquals($tokens, $tokenBag->clear());
        $this->assertEmpty($tokenBag->getAll());
    }

    public function testHasFree()
    {
        $tokenBag = new TokenBag();
        $this->assertFalse($tokenBag->hasFree());
        $tokenBag->add(new Token());
        $this->assertTrue($tokenBag->hasFree());
    }

    public function testCount()
    {
        $tokenBag = new TokenBag();
        $this->assertEquals(0, count($tokenBag));

        $tokens = array(new Token(), new Token());
        $tokenBag->addMultiple($tokens);
        $this->assertEquals(2, count($tokenBag));
    }
}
