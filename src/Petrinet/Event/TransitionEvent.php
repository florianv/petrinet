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

use Petrinet\Transition\TransitionAwareInterface;
use Symfony\Component\EventDispatcher\Event;
use Petrinet\Transition\TransitionInterface;

/**
 * Represents an event involving a transition.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TransitionEvent extends Event implements TransitionAwareInterface
{
    /**
     * The transition.
     *
     * @var TransitionInterface
     */
    protected $transition;

    /**
     * Creates a new transition event.
     *
     * @param TransitionInterface $transition The transition
     */
    public function __construct(TransitionInterface $transition)
    {
        $this->transition = $transition;
    }

    /**
     * {@inheritdoc}
     */
    public function setTransition(TransitionInterface $transition)
    {
        $this->transition = $transition;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransition()
    {
        return $this->transition;
    }
}
