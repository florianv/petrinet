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

/**
 * Depends on a EngineInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface EngineAwareInterface
{
    /**
     * Sets the engine.
     *
     * @param EngineInterface $engine The engine
     */
    public function setEngine(EngineInterface $engine);

    /**
     * Gets the engine.
     *
     * @return EngineInterface The engine
     */
    public function getEngine();
}
