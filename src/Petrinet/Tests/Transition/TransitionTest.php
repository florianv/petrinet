<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Transition;

use Petrinet\Tests\Fixtures\PetrinetProvider;
use Petrinet\Transition\Transition;
use Petrinet\Place\Place;
use Petrinet\Token\Token;
use Petrinet\Arc\Arc;

/**
 * Test class for Transition.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsEnabled()
    {
        $transition = new Transition('t1');
        $this->assertFalse($transition->isEnabled());

        $inputArc1 = new Arc('a1', Arc::PLACE_TO_TRANSITION);
        $inputPlace1 = new Place('p1');
        $inputArc1->setPlace($inputPlace1);
        $inputArc1->setTransition($transition);
        $transition->addInputArc($inputArc1);

        $inputArc2 = new Arc('a2', Arc::PLACE_TO_TRANSITION);
        $inputPlace2 = new Place('p2');
        $inputArc2->setPlace($inputPlace2);
        $inputArc2->setTransition($transition);
        $transition->addInputArc($inputArc2);

        $this->assertFalse($transition->isEnabled());
        $inputPlace1->addToken(new Token());
        $this->assertFalse($transition->isEnabled());
        $inputPlace2->addToken(new Token());
        $this->assertTrue($transition->isEnabled());
    }

    public function testIsEnabledConflictingTransitions()
    {
        $petrinet = PetrinetProvider::getConflictingPetrinet();

        $this->assertTrue($petrinet->getTransition('t1')->isEnabled());
        $this->assertTrue($petrinet->getTransition('t2')->isEnabled());
    }
}
