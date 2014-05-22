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
 * Implementation of TokenInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Token implements TokenInterface
{
    /**
     * The id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
