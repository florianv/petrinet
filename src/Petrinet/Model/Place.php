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

/**
 * Implementation of PlaceInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Place extends AbstractNode implements PlaceInterface
{
    /**
     * {@inheritdoc}
     */
    public function addInputArc(OutputArcInterface $arc)
    {
        $this->inputArcs[] = $arc;
    }

    /**
     * {@inheritdoc}
     */
    public function addOutputArc(InputArcInterface $arc)
    {
        $this->outputArcs[] = $arc;
    }
}
