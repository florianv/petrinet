<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Engine\State;

/**
 * Depends on a EngineStateInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface EngineStateAwareInterface
{
    /**
     * Sets the state.
     *
     * @param EngineStateInterface $state The state
     */
    public function setState(EngineStateInterface $state);

    /**
     * Gets the state.
     *
     * @return StateInterface The state
     */
    public function getState();
}
