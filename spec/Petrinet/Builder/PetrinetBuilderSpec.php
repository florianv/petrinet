<?php

namespace spec\Petrinet\Builder;

use Petrinet\Model\FactoryInterface;
use Petrinet\Model\InputArcInterface;
use Petrinet\Model\OutputArcInterface;
use Petrinet\Model\PetrinetInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\TransitionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PetrinetBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(FactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
        $this->shouldHaveType('Petrinet\Builder\PetrinetBuilder');
    }

    function it_creates_a_place(FactoryInterface $factory, PlaceInterface $place)
    {
        $factory->createPlace()->willReturn($place);

        $this->beConstructedWith($factory);
        $this->place()->shouldReturn($place);
    }

    function it_creates_a_transition(FactoryInterface $factory, TransitionInterface $transition)
    {
        $factory->createTransition()->willReturn($transition);

        $this->beConstructedWith($factory);
        $this->transition()->shouldReturn($transition);
    }

    function it_connects_a_place_to_a_transition(
        FactoryInterface $factory,
        InputArcInterface $arc,
        TransitionInterface $transition,
        PlaceInterface $place
    )
    {
        $factory->createPlace()->willReturn($place);
        $factory->createTransition()->willReturn($transition);
        $factory->createInputArc()->willReturn($arc);

        $arc->setPlace($place)->shouldBeCalled();
        $arc->setTransition($transition)->shouldBeCalled();
        $arc->setWeight(2)->shouldBeCalled();

        $transition->addInputArc($arc)->shouldBeCalled();
        $place->addOutputArc($arc)->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->connect($place, $transition, 2)->shouldReturn($this);
    }

    function it_connects_a_transition_to_a_place(
        FactoryInterface $factory,
        OutputArcInterface $arc,
        TransitionInterface $transition,
        PlaceInterface $place
    )
    {
        $factory->createPlace()->willReturn($place);
        $factory->createTransition()->willReturn($transition);
        $factory->createOutputArc()->willReturn($arc);

        $arc->setTransition($transition)->shouldBeCalled();
        $arc->setPlace($place)->shouldBeCalled();
        $arc->setWeight(1)->shouldBeCalled();

        $transition->addOutputArc($arc)->shouldBeCalled();
        $place->addInputArc($arc)->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->connect($transition, $place)->shouldReturn($this);
    }

    function it_throws_an_excpetion_when_connecting_two_places(
        FactoryInterface $factory,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo
    )
    {
        $this->beConstructedWith($factory);

        $this
            ->shouldThrow(new \InvalidArgumentException('An arc must connect a place to a transition or vice-versa.'))
            ->duringConnect($placeOne, $placeTwo)
        ;
    }

    function it_throws_an_exception_when_connecting_two_transitions(
        FactoryInterface $factory,
        TransitionInterface $transitionOne,
        TransitionInterface $transitionTwo
    )
    {
        $this->beConstructedWith($factory);

        $this
            ->shouldThrow(new \InvalidArgumentException('An arc must connect a place to a transition or vice-versa.'))
            ->duringConnect($transitionOne, $transitionTwo)
        ;
    }

    function it_builds_a_petrinet(
        FactoryInterface $factory,
        PetrinetInterface $petrinet,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        TransitionInterface $transitionOne,
        TransitionInterface $transitionTwo
    )
    {
        $factory->createPetrinet()->willReturn($petrinet);
        $factory->createPlace()->willReturn($placeOne, $placeTwo);
        $factory->createTransition()->willReturn($transitionOne, $transitionTwo);

        $petrinet->setTransitions(array($transitionOne, $transitionTwo))->shouldBeCalled();
        $petrinet->setPlaces(array($placeOne, $placeTwo))->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->place();
        $this->place();
        $this->transition();
        $this->transition();
        $this->getPetrinet()->shouldReturn($petrinet);
    }
}
