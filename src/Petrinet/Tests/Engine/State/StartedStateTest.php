<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Engine\State;

use Petrinet\Tests\Fixtures\PetrinetProvider;
use Petrinet\PetrinetBuilder;
use Petrinet\PetrinetEvents;
use Petrinet\Engine\Engine;

/**
 * Test class for StartedState.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class StartedStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testCannotStartAlreadyStarted()
    {
        $engine = new Engine($this->getMock('Petrinet\PetrinetInterface'));
        $engine->setState($engine->getStartedState());
        $engine->getStartedState()->start();
    }

    public function testStop()
    {
        $mockedDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $mockedDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with(PetrinetEvents::BEFORE_ENGINE_STOP);

        $mockedDispatcher
            ->expects($this->at(1))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_ENGINE_STOP);

        $engine = new Engine($this->getMock('Petrinet\PetrinetInterface'), $mockedDispatcher);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);

        $startedState->stop();

        $this->assertSame($engine->getState(), $engine->getStoppedState());
    }

    public function testStepEventsAreDispatched()
    {
        $petrinet = PetrinetProvider::getSequencePattern();

        $mockedDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $mockedDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with(PetrinetEvents::BEFORE_TRANSITION_FIRE);

        $mockedDispatcher
            ->expects($this->at(1))
            ->method('dispatch')
            ->with(PetrinetEvents::BEFORE_TOKEN_CONSUME);

        $mockedDispatcher
            ->expects($this->at(2))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_TOKEN_CONSUME);

        $mockedDispatcher
            ->expects($this->at(3))
            ->method('dispatch')
            ->with(PetrinetEvents::BEFORE_TOKEN_INSERT);

        $mockedDispatcher
            ->expects($this->at(4))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_TOKEN_INSERT);

        $mockedDispatcher
            ->expects($this->at(5))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_TRANSITION_FIRE);

        $engine = new Engine($petrinet, $mockedDispatcher);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);

        $startedState->step();
    }

    public function testStepWithNoEnabledTransitions()
    {
        $builder = new PetrinetBuilder('p');
        $petrinet = $builder
            ->addPlace('p1')
            ->addTransition('t1')
            ->addTransition('t2')
            ->addPlace('p2')
            ->connectPT('p1', 't1')
            ->connectTP('t1', 'p2')
            ->connectPT('p2', 't2')
            ->connectTP('t2', 'p1')
            ->getPetrinet();

        $engine = new Engine($petrinet);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);
        $startedState->step();

        foreach ($petrinet->getPlaces() as $place) {
            $this->assertCount(0, $place);
        }
    }

    public function testStepWithSequentialTransitions()
    {
        $petrinet = PetrinetProvider::getSequencePattern();
        $p1 = $petrinet->getPlace('p1');
        $p2 = $petrinet->getPlace('p2');
        $p3 = $petrinet->getPlace('p3');

        $engine = new Engine($petrinet);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);

        $startedState->step();

        $this->assertCount(0, $p1);
        $this->assertCount(1, $p2);
        $this->assertCount(0, $p3);

        $startedState->step();

        $this->assertCount(0, $p1);
        $this->assertCount(0, $p2);
        $this->assertCount(1, $p3);
    }

    public function testStepWithConflictingTransitions()
    {
        $petrinet = PetrinetProvider::getConflictPattern();

        $engine = new Engine($petrinet);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);
        $startedState->step();

        $p1 = $petrinet->getPlace('p1');
        $p2 = $petrinet->getPlace('p2');
        $p3 = $petrinet->getPlace('p3');
        $p4 = $petrinet->getPlace('p4');
        $p5 = $petrinet->getPlace('p5');

        // t1 was fired
        if (0 === count($p1)) {
            $this->assertCount(0, $p2);
            $this->assertCount(1, $p3);
            $this->assertCount(1, $p4);
            $this->assertCount(0, $p5);
        }

        // t2 was fired
        elseif (0 === count($p3)) {
            $this->assertCount(1, $p1);
            $this->assertCount(0, $p2);
            $this->assertCount(0, $p4);
            $this->assertCount(1, $p5);
        }
    }

    public function testStepWithMergingTransition()
    {
        $petrinet = PetrinetProvider::getMergePattern();
        $p1 = $petrinet->getPlace('p1');
        $p2 = $petrinet->getPlace('p2');
        $p3 = $petrinet->getPlace('p3');

        $engine = new Engine($petrinet);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);
        $startedState->step();

        $this->assertCount(0, $p1);
        $this->assertCount(0, $p2);
        $this->assertCount(1, $p3);
    }

    public function testStepWithConcurrentTransitions()
    {
        $petrinet = PetrinetProvider::getConcurrencyPattern();
        $p1 = $petrinet->getPlace('p1');
        $p2 = $petrinet->getPlace('p2');
        $p3 = $petrinet->getPlace('p3');
        $p4 = $petrinet->getPlace('p4');
        $p5 = $petrinet->getPlace('p5');

        $engine = new Engine($petrinet);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);
        $startedState->step();

        $this->assertCount(0, $p1);
        $this->assertCount(0, $p2);
        $this->assertCount(0, $p3);
        $this->assertCount(1, $p4);
        $this->assertCount(1, $p5);
    }
}
