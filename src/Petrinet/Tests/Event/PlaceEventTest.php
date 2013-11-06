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

use Petrinet\Event\PlaceEvent;

/**
 * Test class for PlaceEvent.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PlaceEventTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $place = $this->getPlaceMock();
        $event = new PlaceEvent($place);
        $this->assertSame($place, $event->getPlace());
    }

    public function testGetSetPlace()
    {
        $place = $this->getPlaceMock();
        $event = new PlaceEvent($place);

        $otherPlace = $this->getPlaceMock();
        $event->setPlace($otherPlace);
        $this->assertSame($otherPlace, $event->getPlace());
    }

    private function getPlaceMock()
    {
        return $this->getMock('Petrinet\Place\PlaceInterface');
    }
}
