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

/**
 * Test class for StoppedState.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class StoppedStateTest extends \PHPUnit_Framework_TestCase
{
    public function testStart()
    {
        $engine = new Engine($this->getMock('Petrinet\PetrinetInterface'));
        $stoppedState = $engine->getStoppedState();
        $engine->setState($engine->getStoppedState());

        $stoppedState->start();

        $this->assertSame($engine->getState(), $engine->getStartedState());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCannotStopAlreadyStopped()
    {
        $engine = new Engine($this->getMock('Petrinet\PetrinetInterface'));
        $stoppedState = $engine->getStoppedState();
        $stoppedState->stop();
    }
}
