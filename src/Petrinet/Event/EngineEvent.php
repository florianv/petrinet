<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Event;

use Symfony\Component\EventDispatcher\Event;
use Petrinet\Engine\EngineAwareInterface;
use Petrinet\Engine\EngineInterface;

/**
 * Represents an event involving an engine.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class EngineEvent extends Event implements EngineAwareInterface
{
    /**
     * The engine.
     *
     * @var EngineInterface
     */
    protected $engine;

    /**
     * Creates a new engine event.
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Sets the engine.
     *
     * @param EngineInterface $engine The engine
     */
    public function setEngine(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Gets the engine.
     *
     * @return EngineInterface The engine
     */
    public function getEngine()
    {
        return $this->engine;
    }
}
