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

use Petrinet\Transition\Transition;
use Petrinet\Place\Place;
use Petrinet\Token\Token;
use Petrinet\Arc\Arc;

/**
 * Class for building Petrinets.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
final class PetrinetBuilder
{
    /**
     * The Petrinet id.
     *
     * @var string
     */
    private $id;

    /**
     * The places.
     *
     * @var Place[]
     */
    private $places = array();

    /**
     * The transitions.
     *
     * @var Transition[]
     */
    private $transitions = array();

    /**
     * The arcs.
     *
     * @var Arc[]
     */
    private $arcs = array();

    /**
     * Creates a new Petrinet builder.
     *
     * @param string $id The Petrinet id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }


    /**
     * Adds a place.
     *
     * @param string  $id     The place id
     * @param integer $tokens The number of tokens to add in the place
     *
     * @return PetrinetBuilder
     *
     * @throws \LogicException
     */
    public function addPlace($id, $tokens = 0)
    {
        if (isset($this->places[$id])) {
            throw new \LogicException(
                sprintf(
                    'Cannot add the place %s because it was already added',
                    $id
                )
            );
        }

        $place = new Place($id);

        for ($i = 0; $i < $tokens; $i++) {
            $place->addToken(new Token());
        }

        $this->places[$id] = $place;

        return $this;
    }

    /**
     * Adds a token.
     *
     * @param string  $id     The place id
     *
     * @return PetrinetBuilder
     *
     * @throws \LogicException
     */
    public function addTokenOnPlace($id)
    {
        if ( ! isset($this->places[$id])) {
            throw new \LogicException(
                sprintf(
                    'Cannot add the token, place %s does not exist',
                    $id
                )
            );
        }

        $this->places[$id]->addToken(new Token());

        return $this;
    }

    /**
     * Adds a transition.
     *
     * @param string $id The place id
     *
     * @return PetrinetBuilder
     *
     * @throws \LogicException
     */
    public function addTransition($id)
    {
        if (isset($this->transitions[$id])) {
            throw new \LogicException(
                sprintf(
                    'Cannot add the transition %s because it was already added',
                    $id
                )
            );
        }

        $transition = new Transition($id);
        $this->transitions[$id] = $transition;

        return $this;
    }

    /**
     * Connects a place to a transition.
     *
     * @param string $placeId      The place id
     * @param string $transitionId The transition id
     * @param string $id           The arc id
     *
     * @return PetrinetBuilder
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function connectPT($placeId, $transitionId, $id = null)
    {
        if (!isset($this->places[$placeId])) {
            throw new \LogicException(
                sprintf(
                    'Cannot connect the place "%s" to the transition "%s" because the place was not added',
                    $placeId,
                    $transitionId
                )
            );
        }

        if (!isset($this->transitions[$transitionId])) {
            throw new \LogicException(
                sprintf(
                    'Cannot connect the place "%s" to the transition "%s" because the transition was not added',
                    $placeId,
                    $transitionId
                )
            );
        }

        if (null !== $id) {
            if (isset($this->arcs[$id])) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'An arc is already existing with the id "%s"',
                        $id
                    )
                );
            }

            $arcId = $id;
        } else {
            $arcId = '__arc__' . $placeId . '__p__t__' . $transitionId;

            if (isset($this->arcs[$arcId])) {
                throw new \RuntimeException(
                    sprintf(
                        'An arc with id "%s" is already connecting the place %s to the transition "%s"',
                        $arcId,
                        $placeId,
                        $transitionId
                    )
                );
            }
        }

        $place = $this->places[$placeId];
        $transition = $this->transitions[$transitionId];

        $arc = new Arc($arcId, Arc::PLACE_TO_TRANSITION, $place, $transition);
        $this->arcs[$arcId] = $arc;

        $place->addOutputArc($arc);
        $transition->addInputArc($arc);

        return $this;
    }

    /**
     * Connects a transition to a place.
     *
     * @param string $transitionId The transition id
     * @param string $placeId      The place id
     * @param string $id           The arc id
     *
     * @return PetrinetBuilder
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function connectTP($transitionId, $placeId, $id = null)
    {
        if (!isset($this->transitions[$transitionId])) {
            throw new \LogicException(
                sprintf(
                    'Cannot connect the transition "%s" to the place "%s" because the transition was not added',
                    $transitionId,
                    $placeId
                )
            );
        }

        if (!isset($this->places[$placeId])) {
            throw new \LogicException(
                sprintf(
                    'Cannot connect the transition "%s" to the place "%s" because the place was not added',
                    $transitionId,
                    $placeId
                )
            );
        }

        if (null !== $id) {
            if (isset($this->arcs[$id])) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'An arc is already existing with the id "%s"',
                        $id
                    )
                );
            }

            $arcId = $id;
        } else {
            $arcId = '__arc__' . $transitionId . '__t__p__' . $placeId;

            if (isset($this->arcs[$arcId])) {
                throw new \RuntimeException(
                    sprintf(
                        'An arc with id "%s" is already connecting the transition %s to the place "%s"',
                        $arcId,
                        $transitionId,
                        $placeId
                    )
                );
            }
        }

        $place = $this->places[$placeId];
        $transition = $this->transitions[$transitionId];

        $arc = new Arc($arcId, Arc::TRANSITION_TO_PLACE, $place, $transition);
        $this->arcs[$arcId] = $arc;

        $transition->addOutputArc($arc);
        $place->addInputArc($arc);

        return $this;
    }

    /**
     * Gets the Petrinet.
     *
     * @return Petrinet The Petrinet
     */
    public function getPetrinet()
    {
        $petrinet = new Petrinet($this->id);
        $petrinet
            ->addPlaces($this->places)
            ->addTransitions($this->transitions)
            ->addArcs($this->arcs);

        return $petrinet;
    }
}
