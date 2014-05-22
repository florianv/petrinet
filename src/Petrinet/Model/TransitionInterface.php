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
 * Interface for transitions.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface TransitionInterface extends NodeInterface
{
    /**
     * Adds an input arc.
     *
     * @param InputArcInterface $arc
     */
    public function addInputArc(InputArcInterface $arc);

    /**
     * Adds an output arc.
     *
     * @param OutputArcInterface $arc
     */
    public function addOutputArc(OutputArcInterface $arc);
}
