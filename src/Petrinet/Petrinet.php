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

use Petrinet\Transition\TransitionInterface;
use Petrinet\Place\PlaceInterface;
use Petrinet\Arc\ArcInterface;

/**
 * Class representing a Petrinet.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Petrinet implements PetrinetInterface
{
    /**
     * The identifier.
     *
     * @var string
     */
    protected $id;

    /**
     * The places.
     *
     * @var PlaceInterface[]
     */
    protected $places = array();

    /**
     * The transitions.
     *
     * @var TransitionInterface[]
     */
    protected $transitions = array();

    /**
     * The arcs.
     *
     * @var ArcInterface[]
     */
    protected $arcs = array();

    /**
     * Creates a new Petrinet.
     *
     * @param string                $id          The identifier
     * @param PlaceInterface[]      $places      The places
     * @param TransitionInterface[] $transitions The transitions
     * @param ArcInterface[]        $arcs        The arcs
     */
    public function __construct($id, array $places = array(), array $transitions = array(), array $arcs = array())
    {
        $this->id = $id;
        $this->addPlaces($places);
        $this->addTransitions($transitions);
        $this->addArcs($arcs);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Adds a place.
     *
     * @param PlaceInterface $place The place
     *
     * @return Petrinet This method is chainable
     */
    public function addPlace(PlaceInterface $place)
    {
        $this->places[$place->getId()] = $place;

        return $this;
    }

    /**
     * Adds multiple places at once.
     *
     * @param PlaceInterface[] $places The places
     *
     * @return Petrinet This method is chainable
     */
    public function addPlaces(array $places)
    {
        foreach ($places as $place) {
            $this->addPlace($place);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaces()
    {
        return array_values($this->places);
    }

    /**
     * {@inheritdoc}
     */
    public function getPlace($id)
    {
        if (isset($this->places[$id])) {
            return $this->places[$id];
        }

        return null;
    }

    /**
     * Adds a transition.
     *
     * @param TransitionInterface $transition The transition
     *
     * @return Petrinet This method is chainable
     */
    public function addTransition(TransitionInterface $transition)
    {
        $this->transitions[$transition->getId()] = $transition;

        return $this;
    }

    /**
     * Adds multiple transitions at once.
     *
     * @param TransitionInterface[] $transitions The transitions
     *
     * @return Petrinet This method is chainable
     */
    public function addTransitions(array $transitions)
    {
        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTransitions()
    {
        return array_values($this->transitions);
    }

    /**
     * {@inheritdoc}
     */
    public function getTransition($id)
    {
        if (isset($this->transitions[$id])) {
            return $this->transitions[$id];
        }

        return null;
    }

    /**
     * Adds an arc.
     *
     * @param ArcInterface $arc The arc
     *
     * @return Petrinet This method is chainable
     */
    public function addArc(ArcInterface $arc)
    {
        $this->arcs[$arc->getId()] = $arc;

        return $this;
    }

    /**
     * Adds multiple arcs at once.
     *
     * @param ArcInterface[] $arcs The arcs
     *
     * @return Petrinet This method is chainable
     */
    public function addArcs(array $arcs)
    {
        foreach ($arcs as $arc) {
            $this->addArc($arc);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArcs()
    {
        return array_values($this->arcs);
    }

    /**
     * {@inheritdoc}
     */
    public function getArc($id)
    {
        if (isset($this->arcs[$id])) {
            return $this->arcs[$id];
        }

        return null;
    }

    /**
     * Clears all tokens.
     */
    public function clearTokens()
    {
        foreach ($this->places as $place) {
            $place->clearTokens();
        }
    }
}
