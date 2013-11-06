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

use Petrinet\Event\TransitionEvent;

/**
 * Test class for TransitionEvent.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TransitionEventTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $transition = $this->getTransitionMock();
        $event = new TransitionEvent($transition);
        $this->assertSame($transition, $event->getTransition());
    }

    public function testSetGetTransition()
    {
        $transition = $this->getTransitionMock();
        $event = new TransitionEvent($transition);

        $otherTransition = $this->getTransitionMock();
        $event->setTransition($otherTransition);
        $this->assertSame($otherTransition, $event->getTransition());
    }

    private function getTransitionMock()
    {
        return $this->getMock('Petrinet\Transition\TransitionInterface');
    }
}
