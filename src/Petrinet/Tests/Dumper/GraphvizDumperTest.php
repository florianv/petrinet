<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Tests\Dumper;

use Petrinet\Dumper\GraphvizDumper;

/**
 * Test class for GraphvizDumper.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class GraphvizDumperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GraphvizDumper
     */
    private $dumper;

    /**
     * @var string
     */
    private static $graphvizFixturesPath;

    public function setUp()
    {
        $this->dumper = new GraphvizDumper();
    }

    public static function setUpBeforeClass()
    {
        self::$graphvizFixturesPath = realpath(__DIR__ . '/../Fixtures/Graphviz');
    }

    public function testDumpEmptyPetrinet()
    {
        $petrinet = require_once self::$graphvizFixturesPath . '/empty.php';

        $this->assertEquals(
            @file_get_contents(self::$graphvizFixturesPath . '/empty.dot'),
            $this->dumper->dump($petrinet)
        );
    }

    public function testDump()
    {
        $petrinet = require_once self::$graphvizFixturesPath . '/petrinet_1.php';

        $this->assertEquals(
            @file_get_contents(self::$graphvizFixturesPath . '/petrinet_1.dot'),
            $this->dumper->dump($petrinet)
        );
    }
}
