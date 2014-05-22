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
 * Interface for places.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface PlaceInterface extends NodeInterface
{
    /**
     * Adds an input arc.
     *
     * @param OutputArcInterface $arc
     */
    public function addInputArc(OutputArcInterface $arc);

    /**
     * Adds an output arc.
     *
     * @param InputArcInterface $arc
     */
    public function addOutputArc(InputArcInterface $arc);
}
