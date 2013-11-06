<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Event;

use Petrinet\Event\TokenAndPlaceEvent;
use Petrinet\Token\Token;

/**
 * Test class for TokenAndPlaceEvent.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TokenAndPlaceEventTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $place = $this->getPlaceMock();
        $token = new Token();
        $event = new TokenAndPlaceEvent($token, $place);

        $this->assertSame($place, $event->getPlace());
        $this->assertSame($token, $event->getToken());
    }

    public function testSetGetToken()
    {
        $place = $this->getPlaceMock();
        $token = new Token();
        $event = new TokenAndPlaceEvent($token, $place);

        $otherPlace = $this->getPlaceMock();
        $otherToken = new Token();
        $event->setPlace($otherPlace);
        $event->setToken($otherToken);

        $this->assertSame($otherPlace, $event->getPlace());
        $this->assertSame($otherToken, $event->getToken());
    }

    private function getPlaceMock()
    {
        return $this->getMock('Petrinet\Place\PlaceInterface');
    }
}
