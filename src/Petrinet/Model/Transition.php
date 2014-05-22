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
 * Implementation of TransitionInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Transition extends AbstractNode implements TransitionInterface
{
    /**
     * {@inheritdoc}
     */
    public function addInputArc(InputArcInterface $arc)
    {
        $this->inputArcs[] = $arc;
    }

    /**
     * {@inheritdoc}
     */
    public function addOutputArc(OutputArcInterface $arc)
    {
        $this->outputArcs[] = $arc;
    }
}
