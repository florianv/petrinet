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

use Petrinet\Event\EngineEvent;

/**
 * Test class for EngineEvent.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class EngineEventTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $engine = $this->getEngineMock();
        $event = new EngineEvent($engine);
        $this->assertSame($engine, $event->getEngine());
    }

    public function testSetGetEvent()
    {
        $engine = $this->getEngineMock();
        $event = new EngineEvent($engine);

        $otherEngine = $this->getEngineMock();
        $event->setEngine($otherEngine);
        $this->assertSame($otherEngine, $event->getEngine());
    }

    private function getEngineMock()
    {
        return $this->getMock('Petrinet\Engine\EngineInterface');
    }
}
