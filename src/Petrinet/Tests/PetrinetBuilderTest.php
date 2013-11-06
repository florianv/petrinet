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

use Petrinet\PetrinetBuilder;

/**
 * Test class for PetrinetBuilder.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PetrinetBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testAddplace()
    {
        $builder = new PetrinetBuilder('p1');
        $petrinet = $builder
            ->addPlace('p1')
            ->addPlace('p2', 5)
            ->getPetrinet();

        $places = $petrinet->getPlaces();
        $firstPlace = $places[0];
        $secondPlace = $places[1];

        $this->assertEquals('p1', $firstPlace->getId());
        $this->assertEquals(0, count($firstPlace));

        $this->assertEquals('p2', $secondPlace->getId());
        $this->assertEquals(5, count($secondPlace));
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddPlaceExistingException()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->addPlace('p1');
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddTransitionExistingException()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addTransition('t1')
            ->addTransition('t1');
    }

    public function testAddTransition()
    {
        $builder = new PetrinetBuilder('p1');
        $petrinet = $builder
            ->addTransition('t1')
            ->addTransition('t2')
            ->getPetrinet();

        $transitions = $petrinet->getTransitions();
        $firstTransition = $transitions[0];
        $secondTransition = $transitions[1];

        $this->assertEquals('t1', $firstTransition->getId());
        $this->assertEquals('t2', $secondTransition->getId());
    }

    /**
     * @expectedException \LogicException
     */
    public function testConnectPTUnexistingPlace()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addTransition('t1')
            ->connectPT('p1', 't1');
    }

    /**
     * @expectedException \LogicException
     */
    public function testConnectPTUnexistingTransition()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->connectPT('p1', 't1');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConnectPTWithExistingArcId()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->addTransition('t1')
            ->addTransition('t2')
            ->connectPT('p1', 't1', 'arc1')
            ->connectPT('p1', 't2', 'arc1');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConnectPTExistingArcWithoutSpecifyingId()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->addTransition('t1')
            ->connectPT('p1', 't1')
            ->connectPT('p1', 't1');
    }

    /**
     * @expectedException \LogicException
     */
    public function testConnectTPUnexistingPlace()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addTransition('t1')
            ->connectTP('t1', 'p1');
    }

    /**
     * @expectedException \LogicException
     */
    public function testConnectTPUnexistingTransition()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->connectTP('t1', 'p1');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConnectTPWithExistingArcId()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->addTransition('t1')
            ->addTransition('t2')
            ->connectTP('t1', 'p1', 'arc1')
            ->connectTP('t2', 'p1', 'arc1');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConnectTPExistingArcWithoutSpecifyingId()
    {
        $builder = new PetrinetBuilder('p1');
        $builder
            ->addPlace('p1')
            ->addTransition('t1')
            ->connectTP('t1', 'p1')
            ->connectTP('t1', 'p1');
    }

    public function testConnectPTAndTP()
    {
        $builder = new PetrinetBuilder('p1');
        $petrinet = $builder
            ->addPlace('p1')
            ->addTransition('t1')
            ->addTransition('t2')
            ->addPlace('p2')
            ->connectPT('p1', 't1')
            ->connectPT('p1', 't2')
            ->connectTP('t1', 'p2')
            ->connectTP('t2', 'p2')
            ->getPetrinet();

        $arcs = $petrinet->getArcs();

        $arc1 = $arcs[0];
        $this->assertEquals('p1', $arc1->getPlace()->getId());
        $this->assertEquals('p1', $arc1->getFrom()->getId());
        $this->assertEquals('t1', $arc1->getTransition()->getId());
        $this->assertEquals('t1', $arc1->getTo()->getId());

        $arc2 = $arcs[1];
        $this->assertEquals('p1', $arc2->getPlace()->getId());
        $this->assertEquals('p1', $arc2->getFrom()->getId());
        $this->assertEquals('t2', $arc2->getTransition()->getId());
        $this->assertEquals('t2', $arc2->getTo()->getId());

        $arc3 = $arcs[2];
        $this->assertEquals('p2', $arc3->getPlace()->getId());
        $this->assertEquals('p2', $arc3->getTo()->getId());
        $this->assertEquals('t1', $arc3->getTransition()->getId());
        $this->assertEquals('t1', $arc3->getFrom()->getId());

        $arc4 = $arcs[3];
        $this->assertEquals('p2', $arc4->getPlace()->getId());
        $this->assertEquals('p2', $arc4->getTo()->getId());
        $this->assertEquals('t2', $arc4->getTransition()->getId());
        $this->assertEquals('t2', $arc4->getFrom()->getId());

        $p1 = $arc1->getPlace();
        $t1 = $arc1->getTransition();
        $t2 = $arc2->getTransition();
        $p2 = $arc3->getPlace();

        $this->assertEmpty($p1->getInputArcs());
        $this->assertEquals(array($arc1, $arc2), $p1->getOutputArcs());

        $this->assertEquals(array($arc1), $t1->getInputArcs());
        $this->assertEquals(array($arc3), $t1->getOutputArcs());

        $this->assertEquals(array($arc2), $t2->getInputArcs());
        $this->assertEquals(array($arc4), $t2->getOutputArcs());

        $this->assertEquals(array($arc3, $arc4), $p2->getInputArcs());
        $this->assertEmpty($p2->getOutputArcs());
    }
}
