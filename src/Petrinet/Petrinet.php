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
        $this->places[] = $place;

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
     * Gets the places.
     *
     * @return PlaceInterface[] The places
     */
    public function getPlaces()
    {
        return $this->places;
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
        $this->transitions[] = $transition;

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
     * Gets the transitions.
     *
     * @return TransitionInterface[] The transitions
     */
    public function getTransitions()
    {
        return $this->transitions;
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
        $this->arcs[] = $arc;

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
     * Gets the arcs.
     *
     * @return ArcInterface[] The arcs
     */
    public function getArcs()
    {
        return $this->arcs;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabledTransitions()
    {
        $transitions = array();

        foreach ($this->getTransitions() as $transition) {
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
