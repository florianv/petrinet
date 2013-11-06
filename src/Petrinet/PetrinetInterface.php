<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet;

/**
 * Interface for Petrinets.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PetrinetInterface extends ElementInterface
{
    /**
     * Gets the arcs.
     *
     * @return \Petrinet\Arc\ArcInterface[] The arcs
     */
    public function getArcs();

    /**
     * Gets the places.
     *
     * @return \Petrinet\Place\PlaceInterface[] The places
     */
    public function getPlaces();

    /**
     * Gets the transitions.
     *
     * @return \Petrinet\Transition\TransitionInterface[] The transitions
     */
    public function getTransitions();

    /**
     * Gets the enabled transitions (with random order).
     *
     * @return \Petrinet\Transition\TransitionInterface[] The transitions
     */
    public function getEnabledTransitions();
}
