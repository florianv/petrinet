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
 * Interface for place markings.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PlaceMarkingInterface
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
     * Removes the given token.
     *
     * @param TokenInterface $token
     */
    public function removeToken(TokenInterface $token);

    /**
     * Sets the tokens.
     *
     * @param TokenInterface[] $tokens
     */
    public function setTokens($tokens);

    /**
     * Gets the tokens.
     *
     * @return TokenInterface[]
     */
    public function getTokens();
}
