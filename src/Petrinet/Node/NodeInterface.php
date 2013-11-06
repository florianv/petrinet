<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Node;

use Petrinet\ElementInterface;

/**
 * Interface for Petrinet nodes (places or transitions).
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface NodeInterface extends ElementInterface
{
    /**
     * Gets the input arcs.
     *
     * @return \Petrinet\Arc\ArcInterface[] The input arcs
     */
    public function getInputArcs();

    /**
     * Gets the output arcs.
     *
     * @return \Petrinet\Arc\ArcInterface[] The output arcs
     */
    public function getOutputArcs();
}
