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
                $this->fireTransition($transition);
            }
        }
    }

    /**
     * Fires a transition. It supposes the transition is enabled.
     *
     * @param TransitionInterface $transition The transition
     */
    private function fireTransition(TransitionInterface $transition)
    {
        // Firing a previous transition might have disabled this one
        if (!$transition->isEnabled()) {
            return;
        }

        $transitionEvent = new TransitionEvent($transition);
        $this->dispatcher->dispatch(PetrinetEvents::BEFORE_TRANSITION_FIRE, $transitionEvent);

        // If a place is both input and output place of a transition
        // Then its number of tokens does not change
        $inputArcs = $transition->getInputArcs();
        $outputArcs = $transition->getOutputArcs();

        foreach ($inputArcs as $i => $inputArc) {
            $place = $inputArc->getPlace();
            foreach ($outputArcs as $j => $outputArc) {
                if ($place->getId() === $outputArc->getPlace()->getId()) {
                    unset($inputArcs[$i]);
                    unset($outputArcs[$j]);
                }
            }
        }

        // Remove one token from each input place
        foreach ($inputArcs as $arc) {
            $place = $arc->getPlace();
            $token = $place->removeOneToken();

            // No token can be removed if an other transition was enabled at the same time
            // and resulted in the consumption of the unique token from the place
            if (null !== $token) {
                $tokenAndPlaceEvent = new TokenAndPlaceEvent($token, $place);
                $this->dispatcher->dispatch(PetrinetEvents::AFTER_TOKEN_CONSUME, $tokenAndPlaceEvent);
            }
        }

        // Add one token to each output place
        foreach ($outputArcs as $arc) {
            $place = $arc->getPlace();
            $token = new Token();

            $tokenAndPlaceEvent = new TokenAndPlaceEvent($token, $place);
            $this->dispatcher->dispatch(PetrinetEvents::BEFORE_TOKEN_INSERT, $tokenAndPlaceEvent);
            $place->addToken($token);
            $this->dispatcher->dispatch(PetrinetEvents::AFTER_TOKEN_INSERT, $tokenAndPlaceEvent);
        }

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
