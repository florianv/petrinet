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
     * Gets a Petrinet with two sequential transitions.
     *
     * @return \Petrinet\Petrinet
     */
    public static function getSequencePattern()
    {
        $builder = new PetrinetBuilder('p');

        return $builder
            ->addPlace('p1', 1)
            ->addPlace('p2')
            ->addPlace('p3')
            ->addTransition('t1')
            ->addTransition('t2')
            ->connectPT('p1', 't1')
            ->connectTP('t1', 'p2')
            ->connectPT('p2', 't2')
            ->connectTP('t2', 'p3')
            ->getPetrinet();
    }

    /**
     * Gets a Petrinet with two conflicting transitions.
     *
     * @return \Petrinet\Petrinet
     */
    public static function getConflictPattern()
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

    /**
     * Gets a petrinet with a synchronization case.
     *
     * A token must be added to the place 'p2' to enable the transition 't1'.
     *
     * @return \Petrinet\Petrinet
     */
    public static function getSynchronizationPattern()
    {
        $builder = new PetrinetBuilder('p');

        return $builder
            ->addPlace('p1', 1)
            ->addPlace('p2')
            ->addPlace('p3')
            ->addTransition('t1')
            ->addTransition('t2')
            ->connectPT('p1', 't1')
            ->connectPT('p2', 't1')
            ->connectTP('t1', 'p3')
            ->getPetrinet();
    }

    /**
     * Gets a petrinet with a merging case.
     * This is the same as the getSynchronizingPattern but with a token in place 'p2'.
     *
     * @return \Petrinet\Petrinet
     */
    public static function getMergePattern()
    {
        $builder = new PetrinetBuilder('p');

        return $builder
            ->addPlace('p1', 1)
            ->addPlace('p2', 1)
            ->addPlace('p3')
            ->addTransition('t1')
            ->addTransition('t2')
            ->connectPT('p1', 't1')
            ->connectPT('p2', 't1')
            ->connectTP('t1', 'p3')
            ->getPetrinet();
    }

    /**
     * Gets a petrinet with a concurrency case.
     *
     * @return \Petrinet\Petrinet
     */
    public static function getConcurrencyPattern()
    {
        $builder = new PetrinetBuilder('p');

        return $builder
            ->addPlace('p1')
            ->addPlace('p2', 1)
            ->addPlace('p3', 1)
            ->addPlace('p4')
            ->addPlace('p5')
            ->addTransition('t1')
            ->addTransition('t2')
            ->addTransition('t3')
            ->connectPT('p1', 't1')
            ->connectTP('t1', 'p2')
            ->connectTP('t1', 'p3')
            ->connectPT('p2', 't2')
            ->connectPT('p3', 't3')
            ->connectTP('t2', 'p4')
            ->connectTP('t3', 'p5')
            ->getPetrinet();
    }
}
