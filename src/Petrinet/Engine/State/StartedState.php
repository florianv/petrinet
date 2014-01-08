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

use Petrinet\Event\EngineEvent;
use Petrinet\Event\PlaceEvent;
use Petrinet\PetrinetInterface;
use Petrinet\Transition\TransitionInterface;
use Petrinet\Event\TokenAndPlaceEvent;
use Petrinet\Event\TransitionEvent;
use Petrinet\PetrinetEvents;
use Petrinet\Token\Token;

/**
 * Started state.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class StartedState extends AbstractEngineState
{
    /**
     * {@inheritdoc}
     */
    public function start()
    {
        throw new \RuntimeException('The engine is already started');
    }

    /**
     * {@inheritdoc}
     */
    public function stop()
    {
        $engineEvent = new EngineEvent($this->engine);
        $this->dispatcher->dispatch(PetrinetEvents::BEFORE_ENGINE_STOP, $engineEvent);
        $this->engine->setState($this->engine->getStoppedState());
        $this->dispatcher->dispatch(PetrinetEvents::AFTER_ENGINE_STOP, $engineEvent);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        while ($this->engine->getState() !== $this->engine->getStoppedState()) {
            $this->step();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function step()
    {
        $transitions = $this->getEnabledTransitions($this->engine->getPetrinet());

        if (empty($transitions)) {
            $this->engine->stop();
        } else {
            foreach ($transitions as $transition) {
                // Firing a previous transition might have disabled this one
                if ($transition->isEnabled()) {
                    // begin transition
                    $this->firingTransition($transition);
                    // end transition
                    $this->firedTransition($transition);
                }
            }
        }
    }

    /**
     * A transition is firing.
     *
     * @param TransitionInterface $transition The transition
     */
    private function firingTransition(TransitionInterface $transition)
    {
        $transitionEvent = new TransitionEvent($transition);
        $this->dispatcher->dispatch(PetrinetEvents::BEFORE_TRANSITION_FIRE, $transitionEvent);

        // Block one token from each input place
        foreach ($transition->getInputArcs() as $arc) {
            $place = $arc->getPlace();

            $placeEvent = new PlaceEvent($place);
            $this->dispatcher->dispatch(PetrinetEvents::BEFORE_TOKEN_BLOCK, $placeEvent);

            $token = $place->blockOneToken();

            $tokenAndPlaceEvent = new TokenAndPlaceEvent($token, $place);
            $this->dispatcher->dispatch(PetrinetEvents::AFTER_TOKEN_BLOCK, $tokenAndPlaceEvent);
        }
    }

    /**
     * A transition has fired.
     *
     * @param TransitionInterface $transition The transition
     */
    private function firedTransition(TransitionInterface $transition)
    {
        // Consumed one token from each input place
        foreach ($transition->getInputArcs() as $arc) {
            $place = $arc->getPlace();

            $placeEvent = new PlaceEvent($place);
            $this->dispatcher->dispatch(PetrinetEvents::BEFORE_TOKEN_CONSUME, $placeEvent);

            $token = $place->consumeOneToken();

            $tokenAndPlaceEvent = new TokenAndPlaceEvent($token, $place);
            $this->dispatcher->dispatch(PetrinetEvents::AFTER_TOKEN_CONSUME, $tokenAndPlaceEvent);
        }

        // Add one token to each output place
        foreach ($transition->getOutputArcs() as $arc) {
            $place = $arc->getPlace();
            $token = new Token();

            $tokenAndPlaceEvent = new TokenAndPlaceEvent($token, $place);
            $this->dispatcher->dispatch(PetrinetEvents::BEFORE_TOKEN_INSERT, $tokenAndPlaceEvent);

            $place->addToken($token);

            $this->dispatcher->dispatch(PetrinetEvents::AFTER_TOKEN_INSERT, $tokenAndPlaceEvent);
        }

        $transitionEvent = new TransitionEvent($transition);
        $this->dispatcher->dispatch(PetrinetEvents::AFTER_TRANSITION_FIRE, $transitionEvent);
    }

    /**
     * Gets the enabled transitions in the given Petrinet.
     *
     * @param PetrinetInterface $petrinet The Petrinet
     *
     * @return \Petrinet\Transition\TransitionInterface[] The enabled transitions
     */
    private function getEnabledTransitions(PetrinetInterface $petrinet)
    {
        $transitions = array();

        foreach ($petrinet->getTransitions() as $transition) {
            if ($transition->isEnabled()) {
                $transitions[] = $transition;
            }
        }

        if (!empty($transitions)) {
            shuffle($transitions);
        }

        return $transitions;
    }
}
