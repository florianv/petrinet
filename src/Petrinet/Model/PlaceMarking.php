<?php

/**
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
 * Implementation of PlaceMarkingInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class PlaceMarking implements PlaceMarkingInterface
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
     * The tokens.
     *
     * @var ArrayCollection
     */
    protected $tokens;

    /**
     * Creates a new place marking.
     */
    public function __construct()
    {
        $this->tokens = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Adds a token.
     *
     * @param TokenInterface $token
     */
    public function addToken(TokenInterface $token)
    {
        $this->tokens[] = $token;
    }

    /**
     * Tells if the place marking has the given token.
     *
     * @param TokenInterface $token
     */
    public function hasToken(TokenInterface $token)
    {
        $this->tokens->contains($token);
    }

    /**
     * {@inheritdoc}
     */
    public function removeToken(TokenInterface $token)
    {
        $this->tokens->removeElement($token);
    }

    /**
     * {@inheritdoc}
     */
    public function setTokens($tokens)
    {
        $this->tokens = new ArrayCollection();

        foreach ($tokens as $token) {
            $this->addToken($token);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTokens()
    {
        return $this->tokens;
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
