<?php

namespace spec\Petrinet\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Petrinet\Model\Factory');
    }

    function it_creates_a_petrinet()
    {
        $this->createPetrinet()->shouldBeAnInstanceOf('Petrinet\Model\Petrinet');
    }

    function it_throws_an_exception_if_the_object_is_not_a_petrinet_child()
    {
        $this->beConstructedWith('\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The Petrinet class must implement "Petrinet\Model\PetrinetInterface".'))
            ->duringCreatePetrinet()
        ;
    }

    function it_creates_a_place()
    {
        $this->createPlace()->shouldBeAnInstanceOf('Petrinet\Model\Place');
    }

    function it_throws_an_exception_if_the_object_is_not_a_place_child()
    {
        $this->beConstructedWith(null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The place class must implement "Petrinet\Model\PlaceInterface".'))
            ->duringCreatePlace()
        ;
    }

    function it_creates_a_transition()
    {
        $this->createTransition()->shouldBeAnInstanceOf('Petrinet\Model\Transition');
    }

    function it_throws_an_exception_if_the_object_is_not_a_transition_child()
    {
        $this->beConstructedWith(null, null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The transition class must implement "Petrinet\Model\TransitionInterface".'))
            ->duringCreateTransition()
        ;
    }

    function it_creates_an_input_arc()
    {
        $this->createInputArc()->shouldBeAnInstanceOf('Petrinet\Model\InputArc');
    }

    function it_throws_an_exception_if_the_object_is_not_an_input_arc_child()
    {
        $this->beConstructedWith(null, null, null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The input arc class must implement "Petrinet\Model\InputArcInterface".'))
            ->duringcreateInputArc()
        ;
    }

    function it_creates_an_output_arc()
    {
        $this->createOutputArc()->shouldBeAnInstanceOf('Petrinet\Model\OutputArc');
    }

    function it_throws_an_exception_if_the_object_is_not_an_output_arc_child()
    {
        $this->beConstructedWith(null, null, null, null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The output arc class must implement "Petrinet\Model\OutputArcInterface".'))
            ->duringcreateOutputArc()
        ;
    }

    function it_creates_a_place_marking()
    {
        $this->createPlaceMarking()->shouldBeAnInstanceOf('Petrinet\Model\PlaceMarking');
    }

    function it_throws_an_exception_if_the_object_is_not_a_place_marking_child()
    {
        $this->beConstructedWith(null, null, null, null, null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The place marking class must implement "Petrinet\Model\PlaceMarkingInterface".'))
            ->duringCreatePlaceMarking()
        ;
    }

    function it_creates_a_token()
    {
        $this->createToken()->shouldBeAnInstanceOf('Petrinet\Model\Token');
    }

    function it_throws_an_exception_if_the_object_is_not_a_token_child()
    {
        $this->beConstructedWith(null, null, null, null, null, null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The token class must implement "Petrinet\Model\TokenInterface".'))
            ->duringCreateToken()
        ;
    }

    function it_creates_a_marking()
    {
        $this->createMarking()->shouldBeAnInstanceOf('Petrinet\Model\Marking');
    }

    function it_throws_an_exception_if_the_object_is_not_a_marking_child()
    {
        $this->beConstructedWith(null, null, null, null, null, null, null, '\stdClass');

        $this
            ->shouldThrow(new \RuntimeException('The marking class must implement "Petrinet\Model\MarkingInterface".'))
            ->duringCreateMarking()
        ;
    }
}
