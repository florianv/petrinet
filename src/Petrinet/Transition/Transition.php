<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Transition;

use Petrinet\Node\AbstractNode;

/**
 * Transition class.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Transition extends AbstractNode implements TransitionInterface
{
    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        if (empty($this->inputArcs)) {
            return false;
        }

        foreach ($this->inputArcs as $arc) {
            if (!$arc->getPlace()->hasFreeToken()) {
                return false;
            }
        }

        return true;
    }
}
