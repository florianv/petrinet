<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Token;

use Petrinet\ElementInterface;

/**
 * Interface for Tokens.
 *
 * @author Gilles Barbier <gilles@leetix.com>
 */
interface TokenInterface extends ElementInterface
{
    /**
     * Set token's status to free.
     */
    public function setFree();

    /**
     * Set token's status to blocked.
     */
    public function setBlocked();

    /**
     * Set token's status to consumed.
     */
    public function setConsumed();

    /**
     * Returns if this token is free.
     *
     * @return boolean
     */
    public function isFree();

    /**
     * Returns if this token is blocked.
     *
     * @return boolean
     */
    public function isBlocked();

    /**
     * Returns if this token is consumed.
     *
     * @return boolean
     */
    public function isConsumed();
}
