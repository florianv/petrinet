<?php

namespace spec\Petrinet\Model;

use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Petrinet\Model\Marking');
    }

    function it_gets_the_place_marking_when_places_have_ids(
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceMarkingInterface $markingOne,
        PlaceMarkingInterface $markingTwo
    )
    {
        $placeOne->getId()->willReturn(5);
        $placeTwo->getId()->willReturn(10);

        $markingOne->getPlace()->willReturn($placeOne);
        $markingTwo->getPlace()->willReturn($placeTwo);

        $this->addPlaceMarking($markingOne);
        $this->addPlaceMarking($markingTwo);

        $this->getPlaceMarking($placeOne)->shouldReturn($markingOne);
        $this->getPlaceMarking($placeTwo)->shouldReturn($markingTwo);
    }

    function it_gets_the_place_marking_when_places_have_no_id_but_same_instance(
        PlaceInterface $place,
        PlaceMarkingInterface $marking
    )
    {
        $place->getId()->willReturn(null);
        $marking->getPlace()->willReturn($place);

        $this->addPlaceMarking($marking);
        $this->getPlaceMarking($place)->shouldReturn($marking);
    }

    function it_does_not_get_the_marking_when_there_is_none_and_place_id_is_null(
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceMarkingInterface $marking
    )
    {
        $placeOne->getId()->willReturn(null);
        $placeTwo->getId()->willReturn(null);

        $marking->getPlace()->willReturn($placeOne);

        $this->addPlaceMarking($marking);
        $this->getPlaceMarking($placeOne)->shouldReturn($marking);
        $this->getPlaceMarking($placeTwo)->shouldReturn(null);
    }

    function it_adds_two_place_markings_when_places_have_no_id_but_different_instances(
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceMarkingInterface $markingOne,
        PlaceMarkingInterface $markingTwo
    )
    {
        $placeOne->getId()->willReturn(null);
        $placeTwo->getId()->willReturn(null);

        $markingOne->getPlace()->willReturn($placeOne);
        $markingTwo->getPlace()->willReturn($placeTwo);

        $this->addPlaceMarking($markingOne);
        $this->addPlaceMarking($markingTwo);

        $this->getPlaceMarking($placeOne)->shouldReturn($markingOne);
        $this->getPlaceMarking($placeTwo)->shouldReturn($markingTwo);
    }

    function it_throws_an_exception_when_adding_a_duplicated_place_marking(
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceMarkingInterface $markingOne,
        PlaceMarkingInterface $markingTwo
    )
    {
        $placeOne->getId()->willReturn(5);
        $placeTwo->getId()->willReturn(5);

        $markingOne->getPlace()->willReturn($placeOne);
        $markingTwo->getPlace()->willReturn($placeTwo);

        $this->addPlaceMarking($markingOne);

        $this
            ->shouldThrow(new \InvalidArgumentException('Cannot add two markings for the same place.'))
            ->duringAddPlaceMarking($markingTwo)
        ;
    }
}
