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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Implementation of MarkingInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Marking implements MarkingInterface
{
    /**
     * The id.
     *
     * @var integer
     */
    protected $id;

    /**
     * The place markings.
     *
     * @var PlaceMarkingInterface[]
     */
    protected $placeMarkings;

    /**
     * Creates a new marking.
     */
    public function __construct()
    {
        $this->placeMarkings = new ArrayCollection();
    }

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
    public function getPlaceMarking(PlaceInterface $place)
    {
        foreach ($this->placeMarkings as $placeMarking) {
            if ($placeMarking->getPlace() === $place
                || null !== $place->getId() && $placeMarking->getPlace()->getId() === $place->getId()) {
                return $placeMarking;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function addPlaceMarking(PlaceMarkingInterface $marking)
    {
        foreach ($this->placeMarkings as $placeMarking) {
            $place = $placeMarking->getPlace();

            if ($place === $marking->getPlace()
                || null !== $place->getId() && $place->getId() === $marking->getPlace()->getId()) {
                throw new \InvalidArgumentException('Cannot add two markings for the same place.');
            }
        }

        $this->placeMarkings->add($marking);
    }

    /**
     * {@inheritdoc}
     */
    public function setPlaceMarkings($placeMarkings)
    {
        $this->placeMarkings = new ArrayCollection();

        foreach ($placeMarkings as $placeMarking) {
            $this->addPlaceMarking($placeMarking);
        }
    }

    /**
     * Removes a place marking.
     *
     * @param PlaceMarkingInterface $placeMarking
     */
    public function removePlaceMarking(PlaceMarkingInterface $placeMarking)
    {
        $this->placeMarkings->removeElement($placeMarking);
    }

    /**
     * Gets the place markings.
     *
     * @return PlaceMarkingInterface[]
     */
    public function getPlaceMarkings()
    {
        return $this->placeMarkings;
    }
}
