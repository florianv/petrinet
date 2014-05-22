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
 * Interface for markings.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface MarkingInterface
{
    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Gets the marking for a place.
     *
     * @param PlaceInterface $place
     *
     * @return PlaceMarkingInterface|null
     */
    public function getPlaceMarking(PlaceInterface $place);

    /**
     * Adds a place marking.
     *
     * @param PlaceMarkingInterface
     */
    public function addPlaceMarking(PlaceMarkingInterface $marking);

    /**
     * Sets the place markings.
     *
     * @param PlaceMarkingInterface[]
     */
    public function setPlaceMarkings($placeMarkings);
}
