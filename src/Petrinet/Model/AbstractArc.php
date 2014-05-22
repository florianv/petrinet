<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Model;

/**
 * Base class for the arcs.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
abstract class AbstractArc implements ArcInterface
{
    /**
     * The id.
     *
     * @var integer
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
     * The weight.
     *
     * @var integer
     */
    protected $weight;

    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlace(PlaceInterface $place)
    {
        $this->place = $place;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlace()
    {
        return $this->place;
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

    /**
     * {@inheritdoc}
     */
    public function setWeight($weight)
    {
        if ($weight < 0) {
            throw new \InvalidArgumentException('The weight must be a positive integer.');
        }

        $this->weight = $weight;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
