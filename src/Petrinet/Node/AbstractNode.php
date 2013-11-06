<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Node;

use Petrinet\Arc\ArcInterface;

/**
 * Abstract Node class.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
abstract class AbstractNode implements NodeInterface
{
    /**
     * The element identifier.
     *
     * @var string
     */
    protected $id;

    /**
     * The input arcs.
     *
     * @var ArcInterface[]
     */
    protected $inputArcs = array();

    /**
     * The output arcs.
     *
     * @var ArcInterface[]
     */
    protected $outputArcs;

    /**
     * Creates a new abstract node.
     *
     * @param string         $id         The element identifier
     * @param ArcInterface[] $inputArcs  The input arcs
     * @param ArcInterface[] $outputArcs The output arcs
     */
    public function __construct($id, array $inputArcs = array(), array $outputArcs = array())
    {
        $this->id = $id;
        $this->addInputArcs($inputArcs);
        $this->addOutputArcs($outputArcs);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Adds an input arc.
     *
     * @param ArcInterface $arc The arc
     *
     * @return AbstractNode This method is chainable
     */
    public function addInputArc(ArcInterface $arc)
    {
        $this->inputArcs[] = $arc;

        return $this;
    }

    /**
     * Adds multiple input arcs at once.
     *
     * @param ArcInterface[] $inputArcs The arcs
     *
     * @return AbstractNode This method is chainable
     */
    public function addInputArcs(array $inputArcs)
    {
        foreach ($inputArcs as $inputArc) {
            $this->addInputArc($inputArc);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getInputArcs()
    {
        return $this->inputArcs;
    }

    /**
     * Tells if the node has at least one input arc.
     *
     * @return boolean True if the node has at least one input arc
     */
    public function hasAnyInputArc()
    {
        return count($this->inputArcs) > 0;
    }

    /**
     * Adds an output arc.
     *
     * @param ArcInterface $arc The arc
     *
     * @return AbstractNode This method is chainable
     */
    public function addOutputArc(ArcInterface $arc)
    {
        $this->outputArcs[] = $arc;

        return $this;
    }

    /**
     * Adds multiple output arcs at once.
     *
     * @param ArcInterface[] $outputArcs The arcs
     *
     * @return AbstractNode This method is chainable
     */
    public function addOutputArcs(array $outputArcs)
    {
        foreach ($outputArcs as $outputArc) {
            $this->addOutputArc($outputArc);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputArcs()
    {
        return $this->outputArcs;
    }

    /**
     * Tells if the node has at least one output arc.
     *
     * @return boolean True if the node has at least one output arc
     */
    public function hasAnyOutputArc()
    {
        return count($this->outputArcs) > 0;
    }
}
