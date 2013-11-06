<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Arc;

use Petrinet\ElementInterface;

/**
 * Interface for Petrinet arcs.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface ArcInterface extends ElementInterface
{
    /**
     * Gets the place.
     *
     * @return \Petrinet\Place\PlaceInterface The place
     */
    public function getPlace();

    /**
     * Gets the transition.
     *
     * @return \Petrinet\Transition\TransitionInterface The transition
     */
    public function getTransition();

    /**
     * Gets the input node (place or transition).
     *
     * @return \Petrinet\Node\NodeInterface The node
     */
    public function getFrom();

    /**
     * Gets the output node (place or transition).
     *
     * @return \Petrinet\Node\NodeInterface The node
     */
    public function getTo();
}
