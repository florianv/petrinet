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
 * Interface for arcs.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface ArcInterface
{
    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Sets the place.
     *
     * @param PlaceInterface $place
     */
    public function setPlace(PlaceInterface $place);

    /**
     * Gets the place.
     *
     * @return PlaceInterface
     */
    public function getPlace();

    /**
     * Sets the transition.
     *
     * @param TransitionInterface $transition
     */
    public function setTransition(TransitionInterface $transition);

    /**
     * Gets the transition.
     *
     * @return TransitionInterface
     */
    public function getTransition();

    /**
     * Sets the weight.
     *
     * @param integer $weight
     */
    public function setWeight($weight);

    /**
     * Gets the weight.
     *
     * @return integer
     */
    public function getWeight();
}
