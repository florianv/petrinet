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

use Petrinet\Node\NodeInterface;

/**
 * Interface for transitions.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface TransitionInterface extends NodeInterface
{
    /**
     * Tells if the transition is enabled.
     *
     * @return boolean True if enabled, false otherwise
     */
    public function isEnabled();
}
