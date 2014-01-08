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

use Petrinet\Token\Token;

/**
 * Test class for Token.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TokenTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $token = new Token();
        $this->assertNull($token->getId());
        $this->assertTrue($token->isFree());

        $token = new Token('foo');
        $this->assertEquals('foo', $token->getId());
    }

    public function testSetConsumed()
    {
        $token = new Token();
        $token->setConsumed();
        $this->assertFalse($token->isFree());
        $this->assertFalse($token->isBlocked());
        $this->assertTrue($token->isConsumed());
    }

    public function testSetBlocked()
    {
        $token = new Token();
        $token->setBlocked();
        $this->assertFalse($token->isFree());
        $this->assertTrue($token->isBlocked());
        $this->assertFalse($token->isConsumed());
    }

    public function testSetFree()
    {
        $token = new Token();
        $token->setBlocked();
        $token->setFree();
        $this->assertTrue($token->isFree());
        $this->assertFalse($token->isBlocked());
        $this->assertFalse($token->isConsumed());
    }
}
