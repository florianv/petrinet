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

use Petrinet\Petrinet;

/**
 * Test class for Petrinet.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PetrinetTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEnabledTransitions()
    {
        $petrinet = new Petrinet('net');
        $this->assertEmpty($petrinet->getEnabledTransitions());

        $transitionMockOne = $this->getMock('Petrinet\Transition\TransitionInterface');
        $transitionMockOne
            ->expects($this->once())
            ->method('isEnabled')
            ->will($this->returnValue(false));

        $transitionMockTwo = $this->getMock('Petrinet\Transition\TransitionInterface');
        $transitionMockTwo
            ->expects($this->once())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        $transitionMockThree = $this->getMock('Petrinet\Transition\TransitionInterface');
        $transitionMockThree
            ->expects($this->once())
            ->method('isEnabled')
            ->will($this->returnValue(true));

        $petrinet->addTransitions(array($transitionMockOne, $transitionMockTwo, $transitionMockThree));
        $enabledTransitions = $petrinet->getEnabledTransitions();

        $this->assertCount(2, $enabledTransitions);
        $this->assertContains($transitionMockTwo, $enabledTransitions);
        $this->assertContains($transitionMockThree, $enabledTransitions);
    }
}
