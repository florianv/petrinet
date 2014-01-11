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
     */
    public function addToken(Token $token);

    /**
     * Randomly removes one token.
     *
     * @return Token The removed Token
     */
    public function removeOneToken();

    /**
     * Tells if the place is empty.
     *
     * @return boolean True if empty, false otherwise
     */
    public function isEmpty();
}
