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
 * Depends on a PetrinetInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PetrinetAwareInterface
{
    /**
     * Sets the Petrinet.
     *
     * @param PetrinetInterface $petrinet The Petrinet
     */
    public function setPetrinet(PetrinetInterface $petrinet);

    /**
     * Gets the Petrinet.
     *
     * @return PetrinetInterface The Petrinet
     */
    public function getPetrinet();
}
