<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Fixtures;

use Petrinet\PetrinetBuilder;

/**
 * Petrinet provider used in various tests.
 */
final class PetrinetProvider
{
    /**
     * Gets a Petrinet with two conflicting transitions.
     *
     * @return \Petrinet\Petrinet
     */
    public static function getConflictingPetrinet()
    {
        $builder = new PetrinetBuilder('p');

        return $builder
            ->addPlace('p1', 1)
            ->addPlace('p2', 1)
            ->addPlace('p3', 1)
            ->addTransition('t1')
            ->addTransition('t2')
            ->addPlace('p4')
            ->addPlace('p5')
            ->connectPT('p1', 't1')
            ->connectPT('p2', 't1')
            ->connectPT('p2', 't2')
            ->connectPT('p3', 't2')
            ->connectTP('t1', 'p4')
            ->connectTP('t2', 'p5')
            ->getPetrinet();
    }
}
