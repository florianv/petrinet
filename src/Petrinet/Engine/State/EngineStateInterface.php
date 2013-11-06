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

use Petrinet\Engine\EngineAwareInterface;

/**
 * Interface for engines states.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface EngineStateInterface extends StateInterface, EngineAwareInterface
{
    /**
     * Fires transitions until there are no more enabled and stops the engine.
     */
    public function run();

    /**
     * Fires all currently enabled transitions and stops the engine.
     */
    public function step();
}
