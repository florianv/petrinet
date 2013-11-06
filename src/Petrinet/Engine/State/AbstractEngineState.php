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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Petrinet\Engine\EngineInterface;

/**
 * Interface for execution engines states.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
abstract class AbstractEngineState implements EngineStateInterface
{
    /**
     * The engine.
     *
     * @var EngineInterface
     */
    protected $engine;

    /**
     * The dispatcher.
     *
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Creates a new abstract engine state.
     *
     * @param EngineInterface          $engine     The engine
     * @param EventDispatcherInterface $dispatcher The dispatcher
     */
    public function __construct(EngineInterface $engine, EventDispatcherInterface $dispatcher = null)
    {
        $this->engine = $engine;
        $this->dispatcher = $dispatcher ?: new EventDispatcher();
    }

    /**
     * {@inheritdoc}
     */
    public function setEngine(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * {@inheritdoc}
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * {@inheritdoc}
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }
}
