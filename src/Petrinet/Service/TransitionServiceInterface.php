<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Service;

use Petrinet\Model\TransitionInterface;
use Petrinet\Model\MarkingInterface;

/**
 * Contract for transition services.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface TransitionServiceInterface
{
    /**
     * Tells if the transition is enabled in the given marking.
     *
     * @param TransitionInterface $transition
     * @param MarkingInterface    $marking
     *
     * @return boolean
     */
    public function isEnabled(TransitionInterface $transition, MarkingInterface $marking);

    /**
     * Fires a transition in a given marking.
     *
     * @param TransitionInterface $transition
     * @param MarkingInterface    $marking
     *
     * @throws Exception\TransitionNotEnabledException
     */
    public function fire(TransitionInterface $transition, MarkingInterface $marking);
}
