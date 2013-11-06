<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Transition;

/**
 * Depends on a transition.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface TransitionAwareInterface
{
    /**
     * Sets the transition.
     *
     * @param TransitionInterface $transition The transition
     */
    public function setTransition(TransitionInterface $transition);

    /**
     * Gets the transition.
     *
     * @return TransitionInterface The transition
     */
    public function getTransition();
}
