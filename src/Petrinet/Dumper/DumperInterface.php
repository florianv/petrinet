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

use Petrinet\Model\MarkingInterface;
use Petrinet\Model\PetrinetInterface;

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
     * @param PetrinetInterface $petrinet
     * @param MarkingInterface  $marking
     *
     * @return string
     */
    public function dump(PetrinetInterface $petrinet, MarkingInterface $marking = null);
}
