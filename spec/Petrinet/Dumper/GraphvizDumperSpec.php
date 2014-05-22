<?php

namespace spec\Petrinet\Dumper;

use Petrinet\Dumper\GraphvizDumper;
use Petrinet\Model\ArcInterface;
use Petrinet\Model\InputArcInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\OutputArcInterface;
use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\Place;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use Petrinet\Model\TokenInterface;
use Petrinet\Model\TransitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GraphvizDumperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Petrinet\Dumper\GraphvizDumper');
    }

    function it_dumps_a_petrinet(
        PetrinetInterface $petrinet,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        TransitionInterface $transitionOne,
        TransitionInterface $transitionTwo,
        InputArcInterface $arcOne,
        OutputArcInterface $arcTwo,
        InputArcInterface $arcThree,
        OutputArcInterface $arcFour
    )
    {
        $petrinet->getPlaces()->willReturn(array($placeOne, $placeTwo));
        $petrinet->getTransitions()->willReturn(array($transitionOne, $transitionTwo));
        $petrinet->getId()->willReturn(1);

        $placeOne->getInputArcs()->willReturn(array());
        $placeOne->getOutputArcs()->willReturn(array($arcOne));
        $placeOne->getId()->willReturn(1);

        $arcOne->getPlace()->willReturn($placeOne);
        $arcOne->getTransition()->willReturn($transitionOne);
        $arcOne->getId()->willReturn(1);
        $arcOne->getWeight()->willReturn(1);

        $transitionOne->getInputArcs()->willReturn(array($arcOne));
        $transitionOne->getOutputArcs()->willReturn(array($arcTwo));
        $transitionOne->getId()->willReturn(1);

        $arcTwo->getTransition()->willReturn($transitionOne);
        $arcTwo->getPlace()->willReturn($placeTwo);
        $arcTwo->getId()->willReturn(2);
        $arcTwo->getWeight()->willReturn(2);

        $placeTwo->getInputArcs()->willReturn(array($arcTwo));
        $placeTwo->getOutputArcs()->willReturn(array($arcThree));
        $placeTwo->getId()->willReturn(2);

        $arcThree->getPlace()->willReturn($placeTwo);
        $arcThree->getTransition()->willReturn($transitionTwo);
        $arcThree->getId()->willReturn(3);
        $arcThree->getWeight()->willReturn(1);

        $transitionTwo->getInputArcs()->willReturn(array($arcThree));
        $transitionTwo->getOutputArcs()->willReturn(array($arcFour));
        $transitionTwo->getId()->willReturn(2);

        $arcFour->getTransition()->willReturn($transitionTwo);
        $arcFour->getPlace()->willReturn($placeOne);
        $arcFour->getId()->willReturn(4);
        $arcFour->getWeight()->willReturn(2);

        $this->dump($petrinet)->shouldReturn($this->getFirstExpectedDotContent());
    }

    function it_dumps_a_petrinet_with_marking(
        PetrinetInterface $petrinet,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceInterface $placeThree,
        PlaceInterface $placeFour,
        TransitionInterface $transitionOne,
        TransitionInterface $transitionTwo,
        InputArcInterface $arcOne,
        OutputArcInterface $arcTwo,
        InputArcInterface $arcThree,
        OutputArcInterface $arcFour,
        OutputArcInterface $arcFive,
        InputArcInterface $arcSix,
        MarkingInterface $marking,
        PlaceMarkingInterface $placeOneMarking,
        PlaceMarkingInterface $placeThreeMarking,
        TokenInterface $token
    )
    {
        // Petrinet
        $petrinet->getPlaces()->willReturn(array($placeOne, $placeTwo, $placeThree, $placeFour));
        $petrinet->getTransitions()->willReturn(array($transitionOne, $transitionTwo));
        $petrinet->getId()->willReturn(1);

        $placeOne->getInputArcs()->willReturn(array());
        $placeOne->getOutputArcs()->willReturn(array($arcOne));
        $placeOne->getId()->willReturn(1);

        $arcOne->getPlace()->willReturn($placeOne);
        $arcOne->getTransition()->willReturn($transitionOne);
        $arcOne->getId()->willReturn(1);
        $arcOne->getWeight()->willReturn(1);

        $transitionOne->getInputArcs()->willReturn(array($arcOne));
        $transitionOne->getOutputArcs()->willReturn(array($arcTwo, $arcFive));
        $transitionOne->getId()->willReturn(1);

        $arcTwo->getTransition()->willReturn($transitionOne);
        $arcTwo->getPlace()->willReturn($placeTwo);
        $arcTwo->getId()->willReturn(2);
        $arcTwo->getWeight()->willReturn(1);

        $placeTwo->getInputArcs()->willReturn(array($arcTwo));
        $placeTwo->getOutputArcs()->willReturn(array($arcThree));
        $placeTwo->getId()->willReturn(2);

        $arcThree->getPlace()->willReturn($placeTwo);
        $arcThree->getTransition()->willReturn($transitionTwo);
        $arcThree->getId()->willReturn(3);
        $arcThree->getWeight()->willReturn(2);

        $transitionTwo->getInputArcs()->willReturn(array($arcThree));
        $transitionTwo->getOutputArcs()->willReturn(array($arcFour));
        $transitionTwo->getId()->willReturn(2);

        $arcFour->getTransition()->willReturn($transitionTwo);
        $arcFour->getPlace()->willReturn($placeThree);
        $arcFour->getId()->willReturn(4);
        $arcFour->getWeight()->willReturn(1);

        $placeThree->getInputArcs()->willReturn(array($arcFour));
        $placeThree->getOutputArcs()->willReturn(array());
        $placeThree->getId()->willReturn(3);

        $arcFive->getTransition()->willReturn($transitionOne);
        $arcFive->getPlace()->willReturn($placeFour);
        $arcFive->getId()->willReturn(5);
        $arcFive->getWeight()->willReturn(1);

        $placeFour->getInputArcs()->willReturn(array($arcFive));
        $placeFour->getOutputArcs()->willReturn(array($arcSix));
        $placeFour->getId()->willReturn(4);

        $arcSix->getPlace()->willReturn($placeFour);
        $arcSix->getTransition()->willReturn($transitionTwo);
        $arcSix->getId()->willReturn(6);
        $arcSix->getWeight()->willReturn(1);

        // Marking
        $placeOneMarking->getTokens()->willReturn(array($token));
        $placeThreeMarking->getTokens()->willReturn(array($token, $token));

        $marking->getPlaceMarking($placeOne)->willReturn($placeOneMarking);
        $marking->getPlaceMarking($placeTwo)->willReturn(null);
        $marking->getPlaceMarking($placeThree)->willReturn($placeThreeMarking);
        $marking->getPlaceMarking($placeFour)->willReturn(null);

        $this->dump($petrinet, $marking)->shouldReturn($this->getSecondExpectedDotContent());
    }

    private function getFirstExpectedDotContent()
    {
        return <<<DOT
digraph "1" {
"p_1" [label="1 (0 token)"]
"p_2" [label="2 (0 token)"]
"t_1" [label="1" shape=box]
"t_2" [label="2" shape=box]
"p_1" -> "t_1" [label="1"]
"t_1" -> "p_2" [label="2"]
"p_2" -> "t_2" [label="1"]
"t_2" -> "p_1" [label="2"]
}
DOT;
    }

    private function getSecondExpectedDotContent()
    {
        return <<<DOT
digraph "1" {
"p_1" [label="1 (1 token)"]
"p_2" [label="2 (0 token)"]
"p_3" [label="3 (2 tokens)"]
"p_4" [label="4 (0 token)"]
"t_1" [label="1" shape=box]
"t_2" [label="2" shape=box]
"p_1" -> "t_1" [label="1"]
"t_1" -> "p_2" [label="1"]
"p_2" -> "t_2" [label="2"]
"t_2" -> "p_3" [label="1"]
"t_1" -> "p_4" [label="1"]
"p_4" -> "t_2" [label="1"]
}
DOT;
    }
}
