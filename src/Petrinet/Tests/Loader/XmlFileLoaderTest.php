<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Loader;

use Petrinet\Loader\XmlFileLoader;
use Petrinet\Arc\Arc;

/**
 * Test class for XmlFileLoader.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class XmlFileLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructorInvalidFilePathException()
    {
        $loader = new XmlFileLoader();
        $loader->load('unexisting');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionWithTwoIdenticalPlaceIds()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_1.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionWithTwoIdenticalTransitionIds()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_2.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionWithTwoIdenticalArcIds()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_3.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionUnexistingArcFrom()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_4.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionUnexistingArcTo()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_5.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionArcFromTwoPlaces()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_6.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionArcFromTwoTransitions()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_7.xml');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testExceptionPlaceTokensNotNumeric()
    {
        $loader = new XmlFileLoader();
        $loader->load($this->getFixturesPath() . '/petrinet_8.xml');
    }

    public function testLoad()
    {
        $loader = new XmlFileLoader();
        $petrinet = $loader->load($this->getFixturesPath() . '/petrinet_9.xml');
        $p1 = $petrinet->getPlace('p1');
        $p2 = $petrinet->getPlace('p2');
        $t1 = $petrinet->getTransition('t1');
        $t2 = $petrinet->getTransition('t2');
        $arcs = $petrinet->getArcs();
        $a1 = $arcs[0];
        $a2 = $arcs[1];
        $a3 = $arcs[2];
        $a4 = $arcs[3];

        $this->assertEquals('test', $petrinet->getId());

        // p1
        $this->assertEquals('p1', $p1->getId());
        $this->assertEquals(2, count($p1));
        $p1OutputArcs = $p1->getOutputArcs();
        $this->assertSame($a1, $p1OutputArcs[0]);
        $this->assertSame($a2, $p1OutputArcs[1]);

        // a1
        $this->assertEquals('a1', $a1->getId());
        $this->assertSame($a1->getPlace(), $p1);
        $this->assertSame($a1->getTransition(), $t1);
        $this->assertSame($a1->getFrom(), $p1);
        $this->assertSame($a1->getTo(), $t1);

        // t1
        $this->assertEquals('t1', $t1->getId());
        $t1InputArcs = $t1->getInputArcs();
        $this->assertSame($a1, $t1InputArcs[0]);
        $t1OutputArcs = $t1->getOutputArcs();
        $this->assertSame($a3, $t1OutputArcs[0]);

        // a2
        $this->assertEquals('__arc__p1__p__t__t2', $a2->getId());
        $this->assertSame($a2->getPlace(), $p1);
        $this->assertSame($a2->getTransition(), $t2);
        $this->assertSame($a2->getFrom(), $p1);
        $this->assertSame($a2->getTo(), $t2);

        // t2
        $this->assertEquals('t2', $t2->getId());
        $t2InputArcs = $t2->getInputArcs();
        $this->assertSame($a2, $t2InputArcs[0]);
        $t2OutputArcs = $t2->getOutputArcs();
        $this->assertSame($a4, $t2OutputArcs[0]);

        // a3
        $this->assertEquals('__arc__t1__t__p__p2', $a3->getId());
        $this->assertSame($a3->getPlace(), $p2);
        $this->assertSame($a3->getTransition(), $t1);
        $this->assertSame($a3->getFrom(), $t1);
        $this->assertSame($a3->getTo(), $p2);

        // a4
        $this->assertEquals('__arc__t2__t__p__p2', $a4->getId());
        $this->assertSame($a4->getPlace(), $p2);
        $this->assertSame($a4->getTransition(), $t2);
        $this->assertSame($a4->getFrom(), $t2);
        $this->assertSame($a4->getTo(), $p2);

        // p2
        $this->assertEquals('p2', $p2->getId());
        $p2InputArcs = $p2->getInputArcs();
        $this->assertSame($a3, $p2InputArcs[0]);
        $this->assertSame($a4, $p2InputArcs[1]);
    }

    private function getFixturesPath()
    {
        return realpath(__DIR__ . '/../Fixtures/XmlFileLoader');
    }
}
