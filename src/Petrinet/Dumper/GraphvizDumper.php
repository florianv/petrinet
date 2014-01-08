<?php

/**
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Dumper;

use Petrinet\PetrinetInterface;

/**
 * Dumps a Petrinet in Graphviz format.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class GraphvizDumper implements DumperInterface
{
    /**
     * {@inheritdoc}
     */
    public function dump(PetrinetInterface $petrinet)
    {
        $graph = 'digraph ' . $petrinet->getId() . " {\n";

        foreach ($petrinet->getPlaces() as $place) {
            $tokens = $place->countFreeToken();
            $graph .= $place->getId() . ' [label="' . $place->getId() . ': ' . $tokens;
            $tokens > 1 ? $graph .= ' tokens"];' : $graph .= ' token"];';
            $graph .= "\n";
        }

        foreach ($petrinet->getTransitions() as $transition) {
            $graph .= $transition->getId() . " [shape=box];\n";
        }

        foreach ($petrinet->getArcs() as $arc) {
            $input = $arc->getFrom();
            $output = $arc->getTo();
            $graph .= $input->getId() . '->' . $output->getId() . ";\n";
        }

        $graph .= "}";

        return $graph;
    }
}
