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

use Petrinet\Node\AbstractNode;
use Petrinet\Token\TokenBag;
use Petrinet\Token\Token;

/**
 * Represents a Petrinet Place.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Place extends AbstractNode implements PlaceInterface
{
    /**
     * The token bag.
     *
     * @var TokenBag
     */
    protected $tokenBag;

    /**
     * Creates a new place.
     *
     * @param string   $id       The identifier
     * @param TokenBag $tokenBag The token bag
     */
    public function __construct($id, TokenBag $tokenBag = null)
    {
        parent::__construct($id);
        $this->tokenBag = $tokenBag ?: new TokenBag();
    }

    /**
     * Sets the token bag.
     *
     * @param TokenBag $tokenBag The token bag
     *
     * @return Place This method is chainable
     */
    public function setTokenBag(TokenBag $tokenBag)
    {
        $this->tokenBag = $tokenBag;

        return $this;
    }

    /**
     * Gets the token bag.
     *
     * @return TokenBag The token bag
     */
    public function getTokenBag()
    {
        return $this->tokenBag;
    }

    /**
     * Adds a token.
     *
     * @param Token $token The token
     *
     * @return Place
     */
    public function addToken(Token $token)
    {
        $this->tokenBag->add($token);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOneToken()
    {
        return $this->tokenBag->removeOne();
    }

    /**
     * Counts the number of tokens in the place.
     *
     * @return integer The number of tokens
     */
    public function count()
    {
        return count($this->tokenBag);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->tokenBag->isEmpty();
    }
}
