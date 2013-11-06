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

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Depends on a EventDispatcherInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface EventDispatcherAwareInterface
{
    /**
     * Sets the dispatcher.
     *
     * @param EventDispatcherInterface $dispatcher The dispatcher
     */
    public function setDispatcher(EventDispatcherInterface $dispatcher);

    /**
     * Gets the dispatcher.
     *
     * @return EventDispatcherInterface The dispatcher
     */
    public function getDispatcher();
}
