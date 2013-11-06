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
 * Stopped state.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class StoppedState extends AbstractEngineState
{
    /**
     * {@inheritdoc}
     */
    public function start()
    {
        $this->engine->setState($this->engine->getStartedState());
    }

    /**
     * {@inheritdoc}
     */
    public function stop()
    {
        throw new \RuntimeException('The engine is already stopped');
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function step()
    {
    }
}
