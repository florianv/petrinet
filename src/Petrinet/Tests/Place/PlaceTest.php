<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Place;

use Petrinet\Place\Place;
use Petrinet\Token\Token;
use Petrinet\Token\TokenBag;

/**
 * Test class for Place.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PlaceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorTokenBagDefault()
    {
        $place = new Place('p1');
        $this->assertInstanceOf('Petrinet\Token\TokenBag', $place->getTokenBag());
    }

    public function testSetGetTokenBag()
    {
        $place = new Place('p1');
        $tokenBag = new TokenBag();
        $place->setTokenBag($tokenBag);
        $this->assertSame($tokenBag, $place->getTokenBag());
    }

    public function testAddToken()
    {
        $token = new Token();

        $mockedTokenBag = $this->getMock('Petrinet\Token\TokenBag');
        $mockedTokenBag
            ->expects($this->once())
            ->method('add')
            ->with($token);

        $place = new Place('p1', $mockedTokenBag);
        $place->addToken($token);
    }

    public function testRemoveOneToken()
    {
        $mockedTokenBag = $this->getMock('Petrinet\Token\TokenBag');
        $mockedTokenBag
            ->expects($this->once())
            ->method('removeOne');

        $place = new Place('p1', $mockedTokenBag);
        $place->removeOneToken();
    }

    public function testClearTokens()
    {
        $mockedTokenBag = $this->getMock('Petrinet\Token\TokenBag');
        $mockedTokenBag
            ->expects($this->once())
            ->method('clear');

        $place = new Place('p1', $mockedTokenBag);
        $place->clearTokens();
    }

    public function testCount()
    {
        $mockedTokenBag = $this->getMock('Petrinet\Token\TokenBag');
        $mockedTokenBag
            ->expects($this->once())
            ->method('count');

        $place = new Place('p1', $mockedTokenBag);
        count($place);
    }

    public function testIsEmpty()
    {
        $mockedTokenBag = $this->getMock('Petrinet\Token\TokenBag');
        $mockedTokenBag
            ->expects($this->once())
            ->method('isEmpty');

        $place = new Place('p1', $mockedTokenBag);
        $place->isEmpty();
    }
}
