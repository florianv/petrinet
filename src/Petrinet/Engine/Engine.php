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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Petrinet\Engine\State\EngineStateInterface;
use Petrinet\Engine\State\StartedState;
use Petrinet\Engine\State\StoppedState;
use Petrinet\PetrinetInterface;

/**
 * Interface for Petrinet execution engines.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Engine implements EngineInterface
{
    /**
     * Continuous mode.
     *
     * Transitions are fired until there are no more enabled.
     *
     * @var integer
     */
    const MODE_CONTINUOUS = 0;

    /**
     * Stepped mode.
     *
     * The currently enabled transitions are fired
     * and the engine is stopped.
     *
     * @var integer
     */
    const MODE_STEPPED = 1;

    /**
     * The Petrinet for execution.
     *
     * @var PetrinetInterface
     */
    protected $petrinet;

    /**
     * The current state.
     *
     * @var EngineStateInterface
     */
    protected $state;

    /**
     * The started state.
     *
     * @var EngineStateInterface
     */
    protected $startedState;

    /**
     * The stopped state.
     *
     * @var EngineStateInterface
     */
    protected $stoppedState;

    /**
     * The dispatcher.
     *
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * The execution mode.
     *
     * @var integer
     */
    protected $mode = self::MODE_CONTINUOUS;

    /**
     * Creates a new engine.
     *
     * @param PetrinetInterface        $petrinet   The Petrinet to execute
     * @param EventDispatcherInterface $dispatcher The dispatcher
     */
    public function __construct(PetrinetInterface $petrinet, EventDispatcherInterface $dispatcher = null)
    {
        $this->petrinet = $petrinet;
        $this->dispatcher = $dispatcher ?: new EventDispatcher();
        $this->startedState = new StartedState($this, $this->dispatcher);
        $this->stoppedState = new StoppedState($this, $this->dispatcher);
        $this->state = $this->stoppedState;
    }

    /**
     * {@inheritdoc}
     */
    public function setPetrinet(PetrinetInterface $petrinet)
    {
        $this->petrinet = $petrinet;
    }

    /**
     * {@inheritdoc}
     */
    public function getPetrinet()
    {
        return $this->petrinet;
    }

    /**
     * {@inheritdoc}
     */
    public function setState(EngineStateInterface $state)
    {
        $this->state = $state;
    }

    /**
     * {@inheritdoc}
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartedState()
    {
        return $this->startedState;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoppedState()
    {
        return $this->stoppedState;
    }

    /**
     * {@inheritdoc}
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->state->setDispatcher($dispatcher);
        $this->startedState->setDispatcher($dispatcher);
        $this->stoppedState->setDispatcher($dispatcher);
    }

    /**
     * {@inheritdoc}
     */
    public function getDispatcher()
    {
        return $this->dispatcher;
    }

    /**
     * Sets the execution mode.
     *
     * @param integer $mode The execution mode
     *
     * @throws \InvalidArgumentException
     */
    public function setMode($mode)
    {
        if (self::MODE_CONTINUOUS !== $mode && self::MODE_STEPPED !== $mode) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid execution mode "%s" specified',
                    $mode
                )
            );
        }

        $this->mode = $mode;
    }

    /**
     * Gets the execution mode.
     *
     * @return integer The execution mode
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * {@inheritdoc}
     */
    public function start()
    {
        $this->state->start();

        if (self::MODE_CONTINUOUS === $this->mode) {
            $this->state->run();
        } else {
            $this->state->step();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function stop()
    {
        $this->state->stop();
    }
}
