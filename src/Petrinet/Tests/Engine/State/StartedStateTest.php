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

use Petrinet\Engine\Engine;
use Petrinet\PetrinetBuilder;
use Petrinet\PetrinetEvents;

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
            $this->assertTrue($place->isEmpty());
        }
    }

    public function testStepWithEnabledTransitions()
    {
        $builder = new PetrinetBuilder('p');
        $petrinet = $builder
            ->addPlace('p1', 1)
            ->addTransition('t1')
            ->addTransition('t2')
            ->addPlace('p2')
            ->connectPT('p1', 't1')
            ->connectTP('t1', 'p2')
            ->connectPT('p2', 't2')
            ->connectTP('t2', 'p1')
            ->getPetrinet();

        $mockedDispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $mockedDispatcher
            ->expects($this->at(0))
            ->method('dispatch')
            ->with(PetrinetEvents::BEFORE_TRANSITION_FIRE);

        $mockedDispatcher
            ->expects($this->at(1))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_TOKEN_CONSUME);

        $mockedDispatcher
            ->expects($this->at(2))
            ->method('dispatch')
            ->with(PetrinetEvents::BEFORE_TOKEN_INSERT);

        $mockedDispatcher
            ->expects($this->at(3))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_TOKEN_INSERT);

        $mockedDispatcher
            ->expects($this->at(4))
            ->method('dispatch')
            ->with(PetrinetEvents::AFTER_TRANSITION_FIRE);

        $engine = new Engine($petrinet, $mockedDispatcher);
        $startedState = $engine->getStartedState();
        $engine->setState($startedState);

        $startedState->step();

        $place1 = $petrinet->getPlace('p1');
        $place2 = $petrinet->getPlace('p2');

        $this->assertTrue($place1->isEmpty());
        $this->assertEquals(1, count($place2));
    }
}
