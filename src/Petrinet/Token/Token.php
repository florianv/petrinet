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

/**
 * Represents a token.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Token implements TokenInterface
{
    /**
     * Status of a free token (can be used to enable a transition).
     *
     * @var string
     */
    const STATUS_FREE = 'free';

    /**
     * Status of a blocked token (has enabled a transition not yet fired).
     *
     * @var string
     */
    const STATUS_BLOCKED = 'blocked';

    /**
     * Status of a consumed token (has enabled a fired transition).
     *
     * @var string
     */
    const STATUS_CONSUMED = 'consumed';

    /**
     * The token status.
     *
     * @var string
     */
    protected $status;

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
        $this->setFree();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setFree()
    {
        $this->status=self::STATUS_FREE;
    }

    /**
     * {@inheritdoc}
     */
    public function setBlocked()
    {
        $this->status=self::STATUS_BLOCKED;
    }

    /**
     * {@inheritdoc}
     */
    public function setConsumed()
    {
        $this->status=self::STATUS_CONSUMED;
    }

    /**
     * {@inheritdoc}
     */
    public function isFree()
    {
        return $this->status==self::STATUS_FREE;
    }

    /**
     * {@inheritdoc}
     */
    public function isBlocked()
    {
        return $this->status==self::STATUS_BLOCKED;
    }

    /**
     * {@inheritdoc}
     */
    public function isConsumed()
    {
        return $this->status==self::STATUS_CONSUMED;
    }
}
