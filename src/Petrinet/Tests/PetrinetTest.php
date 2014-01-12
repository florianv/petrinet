<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests;

use Petrinet\Transition\Transition;
use Petrinet\Place\Place;
use Petrinet\Arc\Arc;
use Petrinet\Token\Token;
use Petrinet\Petrinet;

/**
 * Test class for Petrinet.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PetrinetTest extends \PHPUnit_Framework_TestCase
{
    public function testAddGetPlaces()
    {
        $place1 = new Place('p1');
        $place2 = new Place('p2');
        $petrinet = new Petrinet('net');
        $petrinet->addPlaces(array($place1, $place2));

        $places = $petrinet->getPlaces();
        $this->assertSame($place1, $petrinet->getPlace('p1'));
        $this->assertSame($place2, $petrinet->getPlace('p2'));
        $this->assertSame($place1, $places[0]);
        $this->assertSame($place2, $places[1]);
    }

    public function testAddGetTransitions()
    {
        $transition1 = new Transition('t1');
        $transition2 = new Transition('t2');
        $petrinet = new Petrinet('net');
        $petrinet->addTransitions(array($transition1, $transition2));

        $transitions = $petrinet->getTransitions();
        $this->assertSame($transition1, $petrinet->getTransition('t1'));
        $this->assertSame($transition2, $petrinet->getTransition('t2'));
        $this->assertSame($transition1, $transitions[0]);
        $this->assertSame($transition2, $transitions[1]);
    }

    public function testAddGetArcs()
    {
        $arc1 = new Arc('a1', Arc::PLACE_TO_TRANSITION);
        $arc2 = new Arc('a2', Arc::PLACE_TO_TRANSITION);
        $petrinet = new Petrinet('net');
        $petrinet->addArcs(array($arc1, $arc2));

        $arcs = $petrinet->getArcs();
        $this->assertSame($arc1, $petrinet->getArc('a1'));
        $this->assertSame($arc2, $petrinet->getArc('a2'));
        $this->assertSame($arc1, $arcs[0]);
        $this->assertSame($arc2, $arcs[1]);
    }

    public function testClearTokens()
    {
        $place1 = new Place('p1');
        $place1->addToken(new Token());
        $place1->addToken(new Token());
        $place2 = new Place('p2');
        $place2->addToken(new Token());
        $place3 = new Place('p3');
        $petrinet = new Petrinet('net');
        $petrinet->addPlaces(array($place1, $place2, $place3));

        $petrinet->clearTokens();

        $this->assertCount(0, $petrinet->getPlace('p1'));
        $this->assertCount(0, $petrinet->getPlace('p2'));
        $this->assertCount(0, $petrinet->getPlace('p3'));
    }
}
