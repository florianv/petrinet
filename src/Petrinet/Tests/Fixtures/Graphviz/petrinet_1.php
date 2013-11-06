<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Petrinet\PetrinetBuilder;

$builder = new PetrinetBuilder('petrinet');

return $builder
    ->addPlace('p1', 5)
    ->addTransition('t1')
    ->connectPT('p1', 't1')
    ->addTransition('t2')
    ->connectPT('p1', 't2')

    ->addPlace('p2')
    ->connectTP('t1', 'p2')
    ->connectTP('t2', 'p2')

    ->getPetrinet();
