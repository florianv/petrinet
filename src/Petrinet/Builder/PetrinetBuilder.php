<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Builder;

use Petrinet\Model\FactoryInterface;
use Petrinet\Model\NodeInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\TransitionInterface;

/**
 * Helps building Petrinets.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PetrinetBuilder
{
    /**
     * The created places.
     *
     * @var PlaceInterface[]
     */
    private $places = array();

    /**
     * The created transitions.
     *
     * @var TransitionInterface[]
     */
    private $transitions = array();

    /**
     * The factory.
     *
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Creates a new Petrinet builder.
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Creates a place.
     *
     * @return \Petrinet\Model\PlaceInterface
     */
    public function place()
    {
        $place = $this->factory->createPlace();
        $this->places[] = $place;

        return $place;
    }

    /**
     * Creates a transition.
     *
     * @return \Petrinet\Model\TransitionInterface
     */
    public function transition()
    {
        $transition = $this->factory->createTransition();
        $this->transitions[] = $transition;

        return $transition;
    }

    /**
     * Connects a place to a transition or vice-versa by an arc of the specified weight.
     *
     * @param NodeInterface $source
     * @param NodeInterface $target
     * @param integer       $weight
     *
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function connect(NodeInterface $source, NodeInterface $target, $weight = 1)
    {
        if ($source instanceof PlaceInterface && $target instanceof TransitionInterface) {
            $arc = $this->factory->createInputArc();
            $arc->setPlace($source);
            $arc->setTransition($target);
        } elseif ($source instanceof TransitionInterface && $target instanceof PlaceInterface) {
            $arc = $this->factory->createOutputArc();
            $arc->setPlace($target);
            $arc->setTransition($source);
        } else {
            throw new \InvalidArgumentException('An arc must connect a place to a transition or vice-versa.');
        }

        $arc->setWeight($weight);
        $source->addOutputArc($arc);
        $target->addInputArc($arc);

        return $this;
    }

    /**
     * Gets the created Petrinet.
     *
     * @return \Petrinet\Model\PetrinetInterface
     */
    public function getPetrinet()
    {
        $petrinet = $this->factory->createPetrinet();
        $petrinet->setPlaces($this->places);
        $petrinet->setTransitions($this->transitions);

        return $petrinet;
    }
}
