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

use Petrinet\Model\ArcInterface;
use Petrinet\Model\InputArcInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\OutputArcInterface;
use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\TransitionInterface;

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
    public function dump(PetrinetInterface $petrinet, MarkingInterface $marking = null)
    {
        $petrinetId = null === $petrinet->getId() ? spl_object_hash($petrinet) : $petrinet->getId();
        $graph = sprintf("digraph \"%s\" {\n", $petrinetId);

        // Process the places
        foreach ($petrinet->getPlaces() as $place) {
            $graph .= sprintf(
                '"%s" [label="%s"]',
                $this->getPlaceId($place),
                $this->getPlaceLabel($place, $marking)
            );
            $graph .= "\n";
        }

        // Process the transitions
        foreach ($petrinet->getTransitions() as $transition) {
            $graph .= sprintf(
                '"%s" [label="%s" shape=box]',
                $this->getTransitionId($transition),
                $this->getTransitionLabel($transition)
            );
            $graph .= "\n";
        }

        // Process the arcs
        foreach ($this->getArcs($petrinet) as $arc) {
            $graph .= sprintf(
                '"%s" -> "%s" [label="%s"]',
                $this->getArcSourceId($arc),
                $this->getArcTargetId($arc),
                $arc->getWeight()
            );
            $graph .= "\n";
        }

        $graph .= '}';

        return $graph;
    }

    /**
     * Gets the arcs in the given Petrinet.
     *
     * @param PetrinetInterface $petrinet
     *
     * @return \Petrinet\Model\ArcInterface[]
     */
    private function getArcs(PetrinetInterface $petrinet)
    {
        $arcs = array();

        foreach ($petrinet->getPlaces() as $place) {
            foreach ($place->getInputArcs() as $inputArc) {
                $inputArcId = null === $inputArc->getId() ? spl_object_hash($inputArc) : $inputArc->getId();
                $arcs[$inputArcId] = $inputArc;
            }

            foreach ($place->getOutputArcs() as $outputArc) {
                $outputArcId = null === $outputArc->getId() ? spl_object_hash($outputArc) : $outputArc->getId();
                $arcs[$outputArcId] = $outputArc;
            }
        }

        foreach ($petrinet->getTransitions() as $transition) {
            foreach ($transition->getInputArcs() as $inputArc) {
                $inputArcId = null === $inputArc->getId() ? spl_object_hash($inputArc) : $inputArc->getId();
                $arcs[$inputArcId] = $inputArc;
            }

            foreach ($transition->getOutputArcs() as $outputArc) {
                $outputArcId = null === $outputArc->getId() ? spl_object_hash($outputArc) : $outputArc->getId();
                $arcs[$outputArcId] = $outputArc;
            }
        }

        return $arcs;
    }

    private function getArcSourceId(ArcInterface $arc)
    {
        if ($arc instanceof InputArcInterface) {
            return $this->getPlaceId($arc->getPlace());
        }

        return $this->getTransitionId($arc->getTransition());
    }

    private function getArcTargetId(ArcInterface $arc)
    {
        if ($arc instanceof OutputArcInterface) {
            return $this->getPlaceId($arc->getPlace());
        }

        return $this->getTransitionId($arc->getTransition());
    }

    private function getPlaceTokensCount(PlaceInterface $place, MarkingInterface $marking = null)
    {
        if (null !== $marking && null !== $placeMarking = $marking->getPlaceMarking($place)) {
            return count($placeMarking->getTokens());
        }

        return 0;
    }

    private function getPlaceId(PlaceInterface $place)
    {
        return null === $place->getId() ? spl_object_hash($place) : 'p_'.$place->getId();
    }

    private function getPlaceLabel(PlaceInterface $place, MarkingInterface $marking = null)
    {
        $placeLabel = null === $place->getId() ? '' : $place->getId();
        $tokensCount = $this->getPlaceTokensCount($place, $marking);

        if ($tokensCount > 1) {
            return sprintf('%s (%s tokens)', $placeLabel, $tokensCount);
        }

        return sprintf('%s (%s token)', $placeLabel, $tokensCount);
    }

    private function getTransitionId(TransitionInterface $transition)
    {
        return null === $transition->getId() ? spl_object_hash($transition) : 't_'.$transition->getId();
    }

    private function getTransitionLabel(TransitionInterface $transition)
    {
        return null === $transition->getId() ? '' : $transition->getId();
    }
}
