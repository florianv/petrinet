<?php

namespace spec\Petrinet\Service;

use Petrinet\Model\FactoryInterface;
use Petrinet\Model\InputArcInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\OutputArcInterface;
use Petrinet\Model\PlaceInterface;
use Petrinet\Model\PlaceMarkingInterface;
use Petrinet\Model\TokenInterface;
use Petrinet\Model\TransitionInterface;
use Petrinet\Service\Exception\TransitionNotEnabledException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransitionServiceSpec extends ObjectBehavior
{
    function it_is_initializable(FactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
        $this->shouldHaveType('Petrinet\Service\TransitionService');
    }

    function it_tells_when_a_transition_is_enabled_in_a_given_marking(
        FactoryInterface $factory,
        InputArcInterface $arcOne,
        InputArcInterface $arcTwo,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceMarkingInterface $placeOneMarking,
        PlaceMarkingInterface $placeTwoMarking,
        TransitionInterface $transition,
        MarkingInterface $marking,
        TokenInterface $token
    )
    {
        $arcOne->getPlace()->willReturn($placeOne);
        $arcOne->getWeight()->willReturn(1);

        $arcTwo->getPlace()->willReturn($placeTwo);
        $arcTwo->getWeight()->willReturn(3);

        $placeOneMarking->getTokens()->willReturn(array($token));
        $placeTwoMarking->getTokens()->willReturn(array($token, $token, $token));

        $marking->getPlaceMarking($placeOne->getWrappedObject())->willReturn($placeOneMarking);
        $marking->getPlaceMarking($placeTwo->getWrappedObject())->willReturn($placeTwoMarking);

        $transition->getInputArcs()->willReturn(array($arcOne, $arcTwo));

        $this->beConstructedWith($factory);
        $this->isEnabled($transition, $marking)->shouldReturn(true);
    }

    function it_tells_a_transition_is_disabled_when_there_is_no_marking_for_the_input_places(
        FactoryInterface $factory,
        InputArcInterface $arc,
        PlaceInterface $place,
        TransitionInterface $transition,
        MarkingInterface $marking
    )
    {
        $arc->getPlace()->willReturn($place);
        $arc->getWeight()->willReturn(1);

        $marking->getPlaceMarking($place->getWrappedObject())->willReturn(null);
        $transition->getInputArcs()->willReturn(array($arc));

        $this->beConstructedWith($factory);
        $this->isEnabled($transition, $marking)->shouldReturn(false);
    }

    function it_tells_when_a_transition_is_disabled_in_a_given_marking(
        FactoryInterface $factory,
        InputArcInterface $arcOne,
        InputArcInterface $arcTwo,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceMarkingInterface $placeOneMarking,
        PlaceMarkingInterface $placeTwoMarking,
        TransitionInterface $transition,
        MarkingInterface $marking,
        TokenInterface $token
    )
    {
        $arcOne->getPlace()->willReturn($placeOne);
        $arcOne->getWeight()->willReturn(1);

        $arcTwo->getPlace()->willReturn($placeTwo);
        $arcTwo->getWeight()->willReturn(1);

        $placeOneMarking->getTokens()->willReturn(array($token));
        $placeTwoMarking->getTokens()->willReturn(array());

        $marking->getPlaceMarking($placeOne->getWrappedObject())->willReturn($placeOneMarking);
        $marking->getPlaceMarking($placeTwo->getWrappedObject())->willReturn($placeTwoMarking);

        $transition->getInputArcs()->willReturn(array($arcOne, $arcTwo));

        $this->beConstructedWith($factory);
        $this->isEnabled($transition, $marking)->shouldReturn(false);
    }

    function it_fires_an_enabled_transition_with_three_input_places_and_two_output_places(
        FactoryInterface $factory,
        MarkingInterface $marking,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        PlaceInterface $placeThree,
        PlaceInterface $placeFour,
        PlaceInterface $placeFive,
        InputArcInterface $arcOne,
        InputArcInterface $arcTwo,
        InputArcInterface $arcThree,
        OutputArcInterface $arcFour,
        OutputArcInterface $arcFive,
        TransitionInterface $transition,
        TokenInterface $token,
        TokenInterface $tokenOne,
        TokenInterface $tokenTwo,
        TokenInterface $tokenThree,
        TokenInterface $tokenFour,
        TokenInterface $tokenFive,
        TokenInterface $tokenSix,
        PlaceMarkingInterface $placeOneMarking,
        PlaceMarkingInterface $placeTwoMarking,
        PlaceMarkingInterface $placeThreeMarking,
        PlaceMarkingInterface $placeFourMarking,
        PlaceMarkingInterface $placeFiveMarking
    )
    {
        $placeOne->getOutputArcs()->willReturn(array($arcOne));
        $placeTwo->getOutputArcs()->willReturn(array($arcTwo));
        $placeThree->getOutputArcs()->willReturn(array($arcThree));
        $placeFour->getInputArcs()->willReturn(array($arcFour));
        $placeFive->getInputArcs()->willReturn(array($arcFive));

        $arcOne->getPlace()->willReturn($placeOne);
        $arcOne->getTransition()->willReturn($transition);
        $arcOne->getWeight()->willReturn(3);

        $arcTwo->getPlace()->willReturn($placeTwo);
        $arcTwo->getTransition()->willReturn($transition);
        $arcTwo->getWeight()->willReturn(2);

        $arcThree->getPlace()->willReturn($placeThree);
        $arcThree->getTransition()->willReturn($transition);
        $arcThree->getWeight()->willReturn(1);

        $arcFour->getTransition()->willReturn($transition);
        $arcFour->getPlace()->willReturn($placeFour);
        $arcFour->getWeight()->willReturn(2);

        $arcFive->getTransition()->willReturn($transition);
        $arcFive->getPlace()->willReturn($placeFive);
        $arcFive->getWeight()->willReturn(1);

        $placeOneMarking->getTokens()->willReturn(array($tokenOne, $tokenTwo, $tokenThree));
        $placeTwoMarking->getTokens()->willReturn(array($tokenFour, $tokenFive));
        $placeThreeMarking->getTokens()->willReturn(array($tokenSix));

        $marking->getPlaceMarking($placeOne->getWrappedObject())->willReturn($placeOneMarking);
        $marking->getPlaceMarking($placeTwo->getWrappedObject())->willReturn($placeTwoMarking);
        $marking->getPlaceMarking($placeThree->getWrappedObject())->willReturn($placeThreeMarking);
        $marking->getPlaceMarking($placeFour->getWrappedObject())->willReturn($placeFourMarking);
        $marking->getPlaceMarking($placeFive->getWrappedObject())->willReturn($placeFiveMarking);

        $transition->getInputArcs()->willReturn(array($arcOne, $arcTwo, $arcThree));
        $transition->getOutputArcs()->willReturn(array($arcFour, $arcFive));

        $factory->createToken()->willReturn($token);

        // Expects tokens to be removed from the input places
        $placeOneMarking->removeToken($tokenOne)->shouldBeCalled();
        $placeOneMarking->removeToken($tokenTwo)->shouldBeCalled();
        $placeOneMarking->removeToken($tokenThree)->shouldBeCalled();

        $placeTwoMarking->removeToken($tokenFour)->shouldBeCalled();
        $placeTwoMarking->removeToken($tokenFive)->shouldBeCalled();

        $placeThreeMarking->removeToken($tokenSix)->shouldBeCalled();

        // Expects tokens to be added to the output places
        $placeFourMarking->setTokens(array($token, $token))->shouldBeCalled();
        $placeFiveMarking->setTokens(array($token))->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->fire($transition, $marking);
    }

    function it_creates_the_output_places_marking_if_not_existing_when_firing_a_transition(
        FactoryInterface $factory,
        PlaceMarkingInterface $placeOneMarking,
        PlaceMarkingInterface $placeTwoMarking,
        MarkingInterface $marking,
        PlaceInterface $placeOne,
        PlaceInterface $placeTwo,
        TransitionInterface $transition,
        InputArcInterface $arcOne,
        OutputArcInterface $arcTwo,
        TokenInterface $token
    )
    {
        $placeOne->getOutputArcs()->willReturn(array($arcOne));

        $arcOne->getPlace()->willReturn($placeOne);
        $arcOne->getTransition()->willReturn($transition);
        $arcOne->getWeight()->willReturn(1);

        $transition->getInputArcs()->willReturn(array($arcOne));
        $transition->getOutputArcs()->willReturn(array($arcTwo));

        $arcTwo->getTransition()->willReturn($transition);
        $arcTwo->getPlace()->willReturn($placeTwo);
        $arcTwo->getWeight()->willReturn(1);

        $factory->createToken()->willReturn($token)->shouldBeCalled();
        $factory->createPlaceMarking()->willReturn($placeTwoMarking)->shouldBeCalled();

        $placeOneMarking->getTokens()->willReturn(array($token));

        $marking->getPlaceMarking($placeOne->getWrappedObject())->willReturn($placeOneMarking);
        $marking->getPlaceMarking($placeTwo->getWrappedObject())->willReturn(null);

        $placeOneMarking->removeToken($token)->shouldBeCalled();
        $placeTwoMarking->setPlace($placeTwo)->shouldBeCalled();
        $placeTwoMarking->setTokens(array($token))->shouldBeCalled();
        $marking->addPlaceMarking($placeTwoMarking)->shouldBeCalled();

        $this->beConstructedWith($factory);
        $this->fire($transition, $marking);
    }

    function it_throws_an_exception_when_firing_a_disabled_transition(
        FactoryInterface $factory,
        MarkingInterface $marking,
        PlaceMarkingInterface $placeMarking,
        TransitionInterface $transition,
        PlaceInterface $place,
        InputArcInterface $arc
    )
    {
        $place->getOutputArcs()->willReturn(array($arc));
        $transition->getInputArcs()->willReturn(array($arc));

        $arc->getPlace()->willReturn($place);
        $arc->getTransition()->willReturn($transition);
        $arc->getWeight()->willReturn(1);

        $placeMarking->getTokens()->willReturn(array());
        $marking->getPlaceMarking($place)->willReturn($placeMarking);

        $this->beConstructedWith($factory);

        $this
            ->shouldThrow(new TransitionNotEnabledException('Cannot fire a disabled transition.'))
            ->duringFire($transition, $marking)
        ;
    }
}
