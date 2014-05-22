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
 * Interface for nodes (places or transitions).
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface NodeInterface
{
    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Gets the output arcs.
     *
     * @return ArcInterface[]
     */
    public function getOutputArcs();

    /**
     * Gets the input arcs.
     *
     * @return ArcInterface[]
     */
    public function getInputArcs();
}
