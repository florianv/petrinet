<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Arc;

use Petrinet\Transition\TransitionInterface;
use Petrinet\Place\PlaceInterface;

/**
 * Represents a Petrinet arc.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Arc implements ArcInterface
{
    const PLACE_TO_TRANSITION = 0;
    const TRANSITION_TO_PLACE = 1;

    /**
     * The element identifier.
     *
     * @var string
     */
    protected $id;

    /**
     * The place.
     *
     * @var PlaceInterface
     */
    protected $place;

    /**
     * The transition.
     *
     * @var TransitionInterface
     */
    protected $transition;

    /**
     * The arc direction.
     *
     * @var integer
     */
    protected $direction;

    /**
     * Creates a new arc.
     *
     * @param string              $id         The element identifier
     * @param integer             $direction  The arc direction
     * @param PlaceInterface      $place      The place
     * @param TransitionInterface $transition The transition
     */
    public function __construct($id, $direction, PlaceInterface $place = null, TransitionInterface $transition = null)
    {
        $this->id = $id;
        $this->setDirection($direction);
        $this->place = $place;
        $this->transition = $transition;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the arc direction.
     *
     * @param integer $direction The direction
     *
     * @return Arc This method is chainable
     *
     * @throws \InvalidArgumentException
     */
    public function setDirection($direction)
    {
        if (self::PLACE_TO_TRANSITION !== $direction && self::TRANSITION_TO_PLACE !== $direction) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid arc direction %s',
                    $direction
                )
            );
        }

        $this->direction = $direction;

        return $this;
    }

    /**
     * Gets the arc direction.
     *
     * @return integer The direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Sets the transition.
     *
     * @param TransitionInterface $transition The transition
     *
     * @return Arc This method is chainable
     */
    public function setTransition(TransitionInterface $transition)
    {
        $this->transition = $transition;

        return $this;
    }

    /**
     * Gets the transition.
     *
     * @return TransitionInterface The transition
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * Sets the place.
     *
     * @param PlaceInterface $place The place
     *
     * @return Arc This method is chainable
     */
    public function setPlace(PlaceInterface $place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Gets the place.
     *
     * @return PlaceInterface The place
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Tells if the arc is from a place to a transition.
     *
     * @return boolean True if from a place to a transition, false otherwise
     */
    public function isFromPlaceToTransition()
    {
        return self::PLACE_TO_TRANSITION === $this->direction;
    }

    /**
     * Tells if the arc is from a transition to a place.
     *
     * @return boolean True if from a transition to a place, false otherwise
     */
    public function isFromTransitionToPlace()
    {
        return self::TRANSITION_TO_PLACE === $this->direction;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        if ($this->isFromPlaceToTransition()) {
            return $this->place;
        }

        return $this->transition;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        if ($this->isFromPlaceToTransition()) {
            return $this->transition;
        }

        return $this->place;
    }
}
