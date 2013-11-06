<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet;

/**
 * Interface for Petrinet elements.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface ElementInterface
{
    /**
     * Gets the element identifier.
     *
     * @return string The identifier
     */
    public function getId();
}
