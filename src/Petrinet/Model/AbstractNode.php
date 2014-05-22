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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Base class for the nodes.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
abstract class AbstractNode implements NodeInterface
{
    /**
     * The id.
     *
     * @var integer
     */
    protected $id;

    /**
     * The input arcs.
     *
     * @var ArrayCollection
     */
    protected $inputArcs;

    /**
     * The output arcs.
     *
     * @var ArrayCollection
     */
    protected $outputArcs;

    /**
     * Creates a new abstract node.
     */
    public function __construct()
    {
        $this->inputArcs = new ArrayCollection();
        $this->outputArcs = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Tells if the node has the input arc.
     *
     * @param ArcInterface $inputArc
     *
     * @return boolean
     */
    public function hasInputArc(ArcInterface $inputArc)
    {
        return $this->inputArcs->contains($inputArc);
    }

    /**
     * Removes the input arc.
     *
     * @param ArcInterface $inputArc
     */
    public function removeInputArc(ArcInterface $inputArc)
    {
        $this->inputArcs->removeElement($inputArc);
    }

    /**
     * {@inheritdoc}
     */
    public function getInputArcs()
    {
        return $this->inputArcs;
    }

    /**
     * Tells if the node has the output arc.
     *
     * @param ArcInterface $outputArc
     *
     * @return boolean
     */
    public function hasOutputArc(ArcInterface $outputArc)
    {
        return $this->outputArcs->contains($outputArc);
    }

    /**
     * Removes the output arc.
     *
     * @param ArcInterface $outputArc
     */
    public function removeOutputArc(ArcInterface $outputArc)
    {
        $this->outputArcs->removeElement($outputArc);
    }

    /**
     * {@inheritdoc}
     */
    public function getOutputArcs()
    {
        return $this->outputArcs;
    }
}
