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

        $token = new Token('foo');
        $this->assertEquals('foo', $token->getId());
    }
}
