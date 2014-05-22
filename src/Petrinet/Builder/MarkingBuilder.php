<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Builder;

use Petrinet\Model\FactoryInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\TokenInterface;

/**
 * Helps building markings.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class MarkingBuilder
{
    /**
     * The created place markings.
     *
     * @var \Petrinet\Model\PlaceMarkingInterface[]
     */
    private $placeMarkings = array();

    /**
     * The factory.
     *
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Creates a new marking builder.
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Marks the place with the specified tokens.
     *
     * @param PlaceInterface                               $place
     * @param \Petrinet\Model\TokenInterface|array|integer $tokens
     *
     * @return MarkingBuilder
     *
     * @throws \InvalidArgumentException
     */
    public function mark(PlaceInterface $place, $tokens)
    {
        if (is_int($tokens)) {
            $tokensCount = $tokens;
            $tokens = array();

            for ($i = 0; $i < $tokensCount; $i++) {
                $tokens[] = $this->factory->createToken();
            }
        } elseif ($tokens instanceof TokenInterface) {
            $tokens = array($tokens);
        } elseif (!is_array($tokens)) {
            throw new \InvalidArgumentException(
                'The $tokens argument must be an array, integer or a Petrinet\Model\TokenInterface instance.'
            );
        }

        $placeMarking = $this->factory->createPlaceMarking();
        $placeMarking->setPlace($place);
        $placeMarking->setTokens($tokens);

        $this->placeMarkings[] = $placeMarking;

        return $this;
    }

    /**
     * Gets the created marking.
     *
     * @return \Petrinet\Model\MarkingInterface
     */
    public function getMarking()
    {
        $marking = $this->factory->createMarking();
        $marking->setPlaceMarkings($this->placeMarkings);

        return $marking;
    }
}
