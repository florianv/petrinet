<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Event;

use Symfony\Component\EventDispatcher\Event;
use Petrinet\Place\PlaceAwareInterface;
use Petrinet\Place\PlaceInterface;

/**
 * Represents an event involving a place.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PlaceEvent extends Event implements PlaceAwareInterface
{
    /**
     * The place.
     *
     * @var PlaceInterface
     */
    protected $place;

    /**
     * Creates a new place event.
     *
     * @param PlaceInterface $place The place
     */
    public function __construct(PlaceInterface $place)
    {
        $this->place = $place;
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
}
