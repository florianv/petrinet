<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Engine;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Petrinet\Tests\Fixtures\PetrinetProvider;
use Petrinet\Engine\Engine;
use Petrinet\Petrinet;

/**
 * Test class for Engine.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class EngineTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultConstructor()
    {
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);

        $startedState = $engine->getStartedState();
        $stoppedState = $engine->getStoppedState();
        $state = $engine->getState();

        $this->assertInstanceOf('Petrinet\Engine\State\StartedState', $startedState);
        $this->assertInstanceOf('Petrinet\Engine\State\StoppedState', $stoppedState);
        $this->assertInstanceOf('Petrinet\Engine\State\StoppedState', $state);
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcherInterface', $engine->getDispatcher());

        $this->assertSame($petrinet, $engine->getPetrinet());
        $this->assertSame($engine, $startedState->getEngine());
        $this->assertSame($engine, $stoppedState->getEngine());
        $this->assertSame($engine, $state->getEngine());
        $this->assertEquals(Engine::MODE_CONTINUOUS, $engine->getMode());
    }

    public function testConstructorInjectsDispatcherInTheStates()
    {
        $dispatcher = new EventDispatcher();
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet, $dispatcher);

        $startedState = $engine->getStartedState();
        $stoppedState = $engine->getStoppedState();
        $state = $engine->getState();

        $this->assertSame($dispatcher, $startedState->getDispatcher());
        $this->assertSame($dispatcher, $stoppedState->getDispatcher());
        $this->assertSame($dispatcher, $state->getDispatcher());
    }

    public function testSetGetDispatcher()
    {
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);
        $dispatcher = new EventDispatcher();

        $engine->setDispatcher($dispatcher);
        $this->assertSame($dispatcher, $engine->getDispatcher());
        $this->assertSame($dispatcher, $engine->getStartedState()->getDispatcher());
        $this->assertSame($dispatcher, $engine->getStoppedState()->getDispatcher());
        $this->assertSame($dispatcher, $engine->getState()->getDispatcher());
    }

    public function testSetGetMode()
    {
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);
        $engine->setMode(Engine::MODE_STEPPED);
        $this->assertEquals(Engine::MODE_STEPPED, $engine->getMode());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetModeWithInvalidMode()
    {
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);
        $engine->setMode(12);
    }

    public function testStartInSteppedMode()
    {
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);
        $engine->setMode(Engine::MODE_STEPPED);

        $mockedState = $this->getMock('Petrinet\Engine\State\EngineStateInterface');
        $mockedState
            ->expects($this->at(0))
            ->method('start');

        $mockedState
            ->expects($this->at(1))
            ->method('step');

        $engine->setState($mockedState);
        $engine->start();
    }

    public function testStartInContinuousMode()
    {
        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);
        $engine->setMode(Engine::MODE_CONTINUOUS);

        $mockedState = $this->getMock('Petrinet\Engine\State\EngineStateInterface');
        $mockedState
            ->expects($this->at(0))
            ->method('start');

        $mockedState
            ->expects($this->at(1))
            ->method('run');

        $engine->setState($mockedState);
        $engine->start();
    }

    public function testStop()
    {
        $mockedState = $this->getMock('Petrinet\Engine\State\EngineStateInterface');
        $mockedState
            ->expects($this->once())
            ->method('stop');

        $petrinet = new Petrinet('p');
        $engine = new Engine($petrinet);
        $engine->setState($mockedState);
        $engine->stop();
    }

    public function testExecutionWithConflictingTransitions()
    {
        $petrinet = PetrinetProvider::getConflictingPetrinet();

        $engine = new Engine($petrinet);
        $engine->setMode(Engine::MODE_STEPPED);
        $engine->start();

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
}
