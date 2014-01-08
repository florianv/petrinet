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
 * Multi set of tokens.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TokenBag implements \Countable, \IteratorAggregate
{
    /**
     * The tokens in the bag.
     *
     * @var Token[]
     */
    protected $tokens = array();

    /**
     * Creates a new token bag.
     *
     * @param Token[] $tokens The tokens
     */
    public function __construct(array $tokens = array())
    {
        $this->addMultiple($tokens);
    }

    /**
     * Adds a token.
     *
     * @param Token $token The token
     */
    public function add(Token $token)
    {
        $this->tokens[] = $token;
    }

    /**
     * Adds multiple tokens.
     *
     * @param Token[] $tokens The tokens
     */
    public function addMultiple(array $tokens)
    {
        foreach ($tokens as $token) {
            $this->add($token);
        }
    }

    /**
     * Randomly blocks one free token.
     *
     * @return Token The blocked Token
     */
    public function blockOne()
    {
        $tokens = $this->getAll();
        shuffle($tokens);
        foreach ($tokens as $token) {
            if ($token->isFree()) {
                $token->setBlocked();
                return $token;
            }
        }
    }

    /**
     * Randomly consumes one blocked token.
     *
     * @return Token The blocked Token
     */
    public function consumeOne()
    {
        $tokens = $this->getAll();
        shuffle($tokens);
        foreach ($tokens as $token) {
            if ($token->isBlocked()) {
                $token->setConsumed();
                return $token;
            }
        }
    }

    /**
     * Clears the bag.
     *
     * @return Token[] The removed tokens
     */
    public function clear()
    {
        $tokens = $this->getAll();
        $this->tokens = array();

        return $tokens;
    }

    /**
     * Gets all tokens in the bag.
     *
     * @return Token[] The tokens
     */
    public function getAll()
    {
        return $this->tokens;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->getAll());
    }

    /**
     * Tells if the bag has at least one free token.
     *
     * @return boolean
     */
    public function hasFree()
    {
        foreach ($this->getAll() as $token) {
            if ($token->isFree()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns number of free tokens.
     *
     * @return integer
     */
    public function countFree()
    {
        $n = 0;
        foreach ($this->getAll() as $token) {
            if ($token->isFree()) {
                $n++;
            }
        }
        return $n;
    }

    /**
     * Returns number of blocked tokens.
     *
     * @return integer
     */
    public function countBlocked()
    {
        $n = 0;
        foreach ($this->getAll() as $token) {
            if ($token->isBlocked()) {
                $n++;
            }
        }
        return $n;
    }

    /**
     * Returns number of consumed tokens.
     *
     * @return integer
     */
    public function countConsumed()
    {
        $n = 0;
        foreach ($this->getAll() as $token) {
            if ($token->isConsumed()) {
                $n++;
            }
        }
        return $n;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->tokens);
    }
}
