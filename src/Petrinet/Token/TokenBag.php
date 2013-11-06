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
     * Randomly removes one token.
     *
     * @return Token The removed Token
     */
    public function removeOne()
    {
        if ($this->isEmpty()) {
            return null;
        }

        $index = array_rand($this->tokens);
        $token = $this->tokens[$index];
        unset($this->tokens[$index]);

        return $token;
    }

    /**
     * Clears the bag.
     *
     * @return Token[] The temoved tokens
     */
    public function clear()
    {
        $tokens = $this->tokens;
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
        return count($this->tokens);
    }

    /**
     * Tells if the bag is empty.
     *
     * @return boolean True if empty, false otherwise
     */
    public function isEmpty()
    {
        return 0 === count($this->tokens);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->tokens);
    }
}
