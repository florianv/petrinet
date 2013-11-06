<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Place;

/**
 * Depends on a PlaceInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PlaceAwareInterface
{
    /**
     * Sets the place.
     *
     * @param PlaceInterface $place The place
     */
    public function setPlace(PlaceInterface $place);

    /**
     * Gets the place.
     *
     * @return PlaceInterface The place
     */
    public function getPlace();
}
