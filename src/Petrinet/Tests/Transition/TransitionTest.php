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
use Petrinet\Token\Token;

/**
 * Test class for Transition.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TransitionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsEnabledSequence()
    {
        $petrinet = PetrinetProvider::getSequencePattern();

        $this->assertTrue($petrinet->getTransition('t1')->isEnabled());
        $this->assertFalse($petrinet->getTransition('t2')->isEnabled());
    }

    public function testIsEnabledConflict()
    {
        $petrinet = PetrinetProvider::getConflictPattern();

        $this->assertTrue($petrinet->getTransition('t1')->isEnabled());
        $this->assertTrue($petrinet->getTransition('t2')->isEnabled());
    }

    public function testIsEnabledSynchronization()
    {
        $petrinet = PetrinetProvider::getSynchronizationPattern();
        $t1 = $petrinet->getTransition('t1');
        $p2 = $petrinet->getPlace('p2');

        $this->assertFalse($t1->isEnabled());

        $p2->addToken(new Token());

        $this->assertTrue($t1->isEnabled());
    }

    public function testIsEnabledConcurrency()
    {
        $petrinet = PetrinetProvider::getConcurrencyPattern();

        $this->assertFalse($petrinet->getTransition('t1')->isEnabled());
        $this->assertTrue($petrinet->getTransition('t2')->isEnabled());
        $this->assertTrue($petrinet->getTransition('t3')->isEnabled());
    }
}
