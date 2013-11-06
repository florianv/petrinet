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

use Petrinet\Place\PlaceInterface;
use Petrinet\Token\Token;

/**
 * Represents an event involving a token and a place.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TokenAndPlaceEvent extends PlaceEvent
{
    /**
     * The token.
     *
     * @var Token
     */
    protected $token;

    /**
     * Creates a new token and place event.
     *
     * @param Token          $token The token
     * @param PlaceInterface $place The place
     */
    public function __construct(Token $token, PlaceInterface $place)
    {
        $this->token = $token;
        $this->place = $place;
    }

    /**
     * {@inheritdoc}
     */
    public function setToken(Token $token)
    {
        $this->token = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->token;
    }
}
