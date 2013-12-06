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
     * Gets the arc identified by the given id.
     *
     * @param integer $id The arc id
     *
     * @return \Petrinet\Arc\ArcInterface|null The arc or null if not found
     */
    public function getArc($id);

    /**
     * Gets the places.
     *
     * @return \Petrinet\Place\PlaceInterface[] The places
     */
    public function getPlaces();

    /**
     * Gets the place identified by the given id.
     *
     * @param integer $id The place id
     *
     * @return \Petrinet\Place\PlaceInterface|null The place or null if not found
     */
    public function getPlace($id);

    /**
     * Gets the transitions.
     *
     * @return \Petrinet\Transition\TransitionInterface[] The transitions
     */
    public function getTransitions();

    /**
     * Gets the transition identified by the given id.
     *
     * @param integer $id The transition id
     *
     * @return \Petrinet\Transition\TransitionInterface|null The transition or null if not found
     */
    public function getTransition($id);

    /**
     * Gets the enabled transitions (in random order).
     *
     * @return \Petrinet\Transition\TransitionInterface[] The transitions
     */
    public function getEnabledTransitions();
}
