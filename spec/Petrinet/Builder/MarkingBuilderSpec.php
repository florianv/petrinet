<?php

namespace spec\Petrinet\Builder;

use Petrinet\Model\FactoryInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use Petrinet\Model\TokenInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkingBuilderSpec extends ObjectBehavior
{
    function it_is_initializable(FactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
        $this->shouldHaveType('Petrinet\Builder\MarkingBuilder');
    }

    function it_marks_a_place_with_one_token(
        FactoryInterface $factory,
        PlaceMarkingInterface $placeMarking,
        PlaceInterface $place,
        TokenInterface $token
    )
    {
        $factory->createPlaceMarking()->willReturn($placeMarking)->shouldBeCalled();

        $placeMarking->setTokens(array($token))->shouldBeCalled();
        $placeMarking->setPlace($place)->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->mark($place, $token)->shouldReturn($this);
    }

    function it_marks_a_place_with_three_tokens(
        FactoryInterface $factory,
        PlaceMarkingInterface $placeMarking,
        PlaceInterface $place,
        TokenInterface $tokenOne,
        TokenInterface $tokenTwo,
        TokenInterface $tokenThree
    )
    {
        $factory->createPlaceMarking()->willReturn($placeMarking);

        $placeMarking->setTokens(array($tokenOne, $tokenTwo, $tokenThree))->shouldBeCalled();
        $placeMarking->setPlace($place)->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->mark($place, array($tokenOne, $tokenTwo, $tokenThree))->shouldReturn($this);
    }

    function it_marks_a_place_with_the_specified_tokens_number(
        FactoryInterface $factory,
        TokenInterface $token,
        PlaceInterface $place,
        PlaceMarkingInterface $placeMarking
    )
    {
        $placeMarking->setTokens(array($token, $token, $token))->shouldBeCalled();
        $placeMarking->setPlace($place)->shouldBeCalled();

        $factory->createPlaceMarking()->willReturn($placeMarking);
        $factory->createToken()->willReturn($token)->shouldBeCalledTimes(3);

        $this->beConstructedWith($factory);
        $this->mark($place, 3)->shouldReturn($this);
    }

    function it_throws_an_exception_when_passing_invalid_token_instances(
        FactoryInterface $factory,
        PlaceInterface $place
    )
    {
        $this->beConstructedWith($factory);

        $this->shouldThrow(
            new \InvalidArgumentException(
                'The $tokens argument must be an array, integer or a Petrinet\Model\TokenInterface instance.'
            ))
         ->duringMark($place, new \stdClass());
    }

    function it_builds_a_marking_with_three_place_markings(
        FactoryInterface $factory,
        MarkingInterface $marking,
        PlaceMarkingInterface $placeMarkingOne,
        PlaceMarkingInterface $placeMarkingTwo,
        PlaceMarkingInterface $placeMarkingThree,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceInterface $placeThree,
        TokenInterface $token
    )
    {
        $factory->createMarking()->willReturn($marking);
        $factory->createPlaceMarking()->willReturn($placeMarkingOne, $placeMarkingTwo, $placeMarkingThree);
        $factory->createToken()->willReturn($token)->shouldBeCalledTimes(3);

        $marking->setPlaceMarkings(array($placeMarkingOne, $placeMarkingTwo, $placeMarkingThree))->shouldBeCalled();

        $placeMarkingOne->setPlace($placeOne)->shouldBeCalled();
        $placeMarkingOne->setTokens(array($token))->shouldBeCalled();

        $placeMarkingTwo->setPlace($placeTwo)->shouldBeCalled();
        $placeMarkingTwo->setTokens(array($token, $token))->shouldBeCalled();

        $placeMarkingThree->setPlace($placeThree)->shouldBeCalled();
        $placeMarkingThree->setTokens(array($token, $token, $token))->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->mark($placeOne, $token);
        $this->mark($placeTwo, array($token, $token));
        $this->mark($placeThree, 3);
        $this->getMarking()->shouldReturn($marking);
    }
}
