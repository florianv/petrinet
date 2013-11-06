<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Node;

/**
 * Test class for AbstractNode.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class AbstractNodeTest extends \PHPUnit_Framework_TestCase
{
    public function testAddInputArc()
    {
        $node = new ConcreteNode('foo');
        $arc = $this->getMock('Petrinet\Arc\ArcInterface');
        $node->addInputArc($arc);
        $node->addInputArc($arc);
        $inputArcs = $node->getInputArcs();
        $this->assertSame($arc, $inputArcs[0]);
        $this->assertSame($arc, $inputArcs[1]);
    }

    public function testAddInputArcs()
    {
        $node = new ConcreteNode('foo');
        $arc = $this->getMock('Petrinet\Arc\ArcInterface');
        $arcs = array($arc, $arc);
        $node->addInputArcs($arcs);
        $inputArcs = $node->getInputArcs();
        $this->assertSame($arcs, $inputArcs);
    }

    public function testHasAnyInputArc()
    {
        $node = new ConcreteNode('foo');
        $this->assertFalse($node->hasAnyInputArc());

        $arc = $this->getMock('Petrinet\Arc\ArcInterface');
        $node->addInputArc($arc);
        $this->assertTrue($node->hasAnyInputArc());
    }

    public function testGetInputArcsEmpty()
    {
        $node = new ConcreteNode('foo');
        $this->assertEmpty($node->getInputArcs());
    }

    public function testAddOutputArc()
    {
        $node = new ConcreteNode('foo');
        $arc = $this->getMock('Petrinet\Arc\ArcInterface');
        $node->addOutputArc($arc);
        $node->addOutputArc($arc);
        $outputArcs = $node->getOutputArcs();
        $this->assertSame($arc, $outputArcs[0]);
        $this->assertSame($arc, $outputArcs[1]);
    }

    public function testAddOutputArcs()
    {
        $node = new ConcreteNode('foo');
        $arc = $this->getMock('Petrinet\Arc\ArcInterface');
        $arcs = array($arc, $arc);
        $node->addOutputArcs($arcs);
        $outputArcs = $node->getOutputArcs();
        $this->assertSame($arcs, $outputArcs);
    }

    public function testHasAnyOutputArc()
    {
        $node = new ConcreteNode('foo');
        $this->assertFalse($node->hasAnyOutputArc());

        $arc = $this->getMock('Petrinet\Arc\ArcInterface');
        $node->addOutputArc($arc);
        $this->assertTrue($node->hasAnyOutputArc());
    }

    public function testGetOutputArcsEmpty()
    {
        $node = new ConcreteNode('foo');
        $this->assertEmpty($node->getOutputArcs());
    }
}
