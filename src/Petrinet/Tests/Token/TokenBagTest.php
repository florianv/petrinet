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
        $this->assertTrue($tokenBag->isEmpty());

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

    public function testRemoveOne()
    {
        $tokenBag = new TokenBag();
        $this->assertNull($tokenBag->removeOne());

        $token = new Token();
        $tokenBag->add($token);
        $this->assertSame($token, $tokenBag->removeOne());
        $this->assertTrue($tokenBag->isEmpty());
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

    public function testCount()
    {
        $tokenBag = new TokenBag();
        $this->assertEquals(0, count($tokenBag));

        $tokens = array(new Token(), new Token());
        $tokenBag->addMultiple($tokens);
        $this->assertEquals(2, count($tokenBag));
    }

    public function testIsEmpty()
    {
        $tokenBag = new TokenBag();
        $this->assertTrue($tokenBag->isEmpty());
        $tokenBag->add(new Token());
        $this->assertFalse($tokenBag->isEmpty());
    }
}
