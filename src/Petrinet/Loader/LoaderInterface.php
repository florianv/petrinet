<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Loader;

/**
 * Interface for Petrinet loaders.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface LoaderInterface
{
    /**
     * Loads a Petrinet.
     *
     * @return \Petrinet\PetrinetInterface The Petrinet
     */
    public function load();
}
