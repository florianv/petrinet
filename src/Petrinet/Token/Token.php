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
 * Represents a token.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Token implements ElementInterface
{
    /**
     * The token id.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates a new token.
     *
     * @param string $id The token id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
