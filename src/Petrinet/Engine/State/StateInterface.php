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

use Petrinet\Event\EventDispatcherAwareInterface;

/**
 * Interface for engine states.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface StateInterface extends EventDispatcherAwareInterface
{
    /**
     * Starts the execution.
     *
     * @throws \RuntimeException
     */
    public function start();

    /**
     * Stops the execution.
     *
     * @throws \RuntimeException
     */
    public function stop();
}
