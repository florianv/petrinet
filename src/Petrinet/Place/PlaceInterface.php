<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Place;

use Petrinet\Node\NodeInterface;
use Petrinet\Token\Token;

/**
 * Interface for places.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PlaceInterface extends \Countable, NodeInterface
{
    /**
     * Adds a token.
     *
     * @param Token $token The token
     *
     * @return PlaceInterface This method is chainable
     */
    public function addToken(Token $token);

    /**
     * Randomly blocks one free token.
     *
     * @return Token The blocked Token
     */
    public function blockOneToken();

    /**
     * Randomly consumes one blocked token.
     *
     * @return Token The consumed Token
     */
    public function consumeOneToken();

    /**
     * Tells if the place has at least one free token.
     *
     * @return boolean
     */
    public function hasFreeToken();
}
