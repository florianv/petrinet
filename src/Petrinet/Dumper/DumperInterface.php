<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Dumper;

use Petrinet\PetrinetInterface;

/**
 * Interface for Petrinet dumpers.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface DumperInterface
{
    /**
     * Dumps a Petrinet.
     *
     * @param PetrinetInterface $petrinet The Petrinet
     *
     * @return string The string representation
     */
    public function dump(PetrinetInterface $petrinet);
}
