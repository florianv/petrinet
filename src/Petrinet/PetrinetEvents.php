<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet;

/**
 * Lists all event names.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
final class PetrinetEvents
{
    /**
     * Event triggered before an engine is stopped.
     *
     * The listeners will receive a Petrinet\Event\EngineEvent.
     *
     * @var string
     */
    const BEFORE_ENGINE_STOP = 'before.engine.stop';

    /**
     * Event triggered after an engine is stopped.
     *
     * The listeners will receive a Petrinet\Event\EngineEvent.
     *
     * @var string
     */
    const AFTER_ENGINE_STOP = 'after.engine.stop';

    /**
     * Event triggered before a transition is fired.
     *
     * The listeners will receive a Petrinet\Event\TransitionEvent.
     *
     * @var string
     */
    const BEFORE_TRANSITION_FIRE = 'before.transition.fire';

    /**
     * Event triggered after a transition is fired.
     *
     * The listeners will receive a Petrinet\Event\TransitionEvent.
     *
     * @var string
     */
    const AFTER_TRANSITION_FIRE = 'after.transition.fire';

    /**
     * Event triggered before a token is inserted into a place.
     *
     * The listeners will receive a Petrinet\Event\TokenAndPlaceEvent.
     *
     * @var string
     */
    const BEFORE_TOKEN_INSERT = 'before.token.insert';

    /**
     * Event triggered after a token is inserted into a place.
     *
     * The listeners will receive a Petrinet\Event\TokenAndPlaceEvent.
     *
     * @var string
     */
    const AFTER_TOKEN_INSERT = 'after.token.insert';

    /**
     * Event triggered before a token is removed from a place (consumed).
     *
     * The listeners will receive a Petrinet\Event\PlaceEvent.
     *
     * @var string
     */
    const BEFORE_TOKEN_CONSUME = 'before.token.consume';

    /**
     * Event triggered after a token is removed from a place (consumed).
     *
     * The listeners will receive a Petrinet\Event\TokenAndPlaceEvent.
     *
     * @var string
     */
    const AFTER_TOKEN_CONSUME = 'after.token.consume';
}
