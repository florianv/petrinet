<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Model;

/**
 * Interface for Petrinets.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PetrinetInterface
{
    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Sets the transitions.
     *
     * @param TransitionInterface[] $transitions
     */
    public function setTransitions($transitions);

    /**
     * Gets the transitions.
     *
     * @return TransitionInterface[]
     */
    public function getTransitions();

    /**
     * Sets the places.
     *
     * @param PlaceInterface[] $places
     */
    public function setPlaces($places);

    /**
     * Gets the places.
     *
     * @return PlaceInterface[]
     */
    public function getPlaces();
}
