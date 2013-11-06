<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Arc;

use Petrinet\Transition\Transition;
use Petrinet\Place\Place;
use Petrinet\Arc\Arc;

/**
 * Test class for Arc.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class ArcTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorWithInvalidDirection()
    {
        new Arc('a1', 8);
    }

    public function testSetGetDirection()
    {
        $arc = new Arc('a1', Arc::PLACE_TO_TRANSITION);
        $this->assertEquals(Arc::PLACE_TO_TRANSITION, $arc->getDirection());
        $arc->setDirection(Arc::TRANSITION_TO_PLACE);
        $this->assertEquals(Arc::TRANSITION_TO_PLACE, $arc->getDirection());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetDirectionWithInvalidDirection()
    {
        $arc = new Arc('a1', Arc::TRANSITION_TO_PLACE);
        $arc->setDirection('non-existing');
    }

    public function testSetGetTransition()
    {
        $transition = new Transition('p1');
        $arc = new Arc('a1', Arc::PLACE_TO_TRANSITION);
        $arc->setTransition($transition);
        $this->assertSame($arc->getTransition(), $transition);
    }

    public function testSetGetPlace()
    {
        $place = new Place('p1');
        $arc = new Arc('a1', Arc::PLACE_TO_TRANSITION);
        $arc->setPlace($place);
        $this->assertSame($arc->getPlace(), $place);
    }

    public function testIsFromPlaceToTransition()
    {
        $arc = new Arc('a1', Arc::PLACE_TO_TRANSITION);
        $this->assertTrue($arc->isFromPlaceToTransition());
        $arc->setDirection(Arc::TRANSITION_TO_PLACE);
        $this->assertFalse($arc->isFromPlaceToTransition());
    }

    public function testIsFromTransitionToPlace()
    {
        $arc = new Arc('a1', Arc::TRANSITION_TO_PLACE);
        $this->assertTrue($arc->isFromTransitionToPlace());
        $arc->setDirection(Arc::PLACE_TO_TRANSITION);
        $this->assertFalse($arc->isFromTransitionToPlace());
    }

    public function testGetFrom()
    {
        $place = new Place('p1');
        $transition = new Transition('t1');
        $arc = new Arc('a1', Arc::PLACE_TO_TRANSITION, $place, $transition);
        $this->assertSame($place, $arc->getFrom());
        $arc->setDirection(Arc::TRANSITION_TO_PLACE);
        $this->assertSame($transition, $arc->getFrom());
    }

    public function testGetTo()
    {
        $place = new Place('p1');
        $transition = new Transition('t1');
        $arc = new Arc('a1', Arc::PLACE_TO_TRANSITION, $place, $transition);
        $this->assertSame($transition, $arc->getTo());
        $arc->setDirection(Arc::TRANSITION_TO_PLACE);
        $this->assertSame($place, $arc->getTo());
    }
}
