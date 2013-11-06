<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Engine;

use Petrinet\Engine\State\EngineStateAwareInterface;
use Petrinet\Engine\State\EngineStateInterface;
use Petrinet\Engine\State\StateInterface;
use Petrinet\PetrinetAwareInterface;

/**
 * Interface for Petrinet execution engines.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface EngineInterface extends StateInterface, EngineStateAwareInterface, PetrinetAwareInterface
{
    /**
     * Gets the started state.
     *
     * @return EngineStateInterface The started state
     */
    public function getStartedState();

    /**
     * Gets the stopped state.
     *
     * @return EngineStateInterface The stopped state
     */
    public function getStoppedState();
}
