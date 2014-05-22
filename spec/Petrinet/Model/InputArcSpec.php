<?php

namespace spec\Petrinet\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputArcSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Petrinet\Model\InputArc');
    }

    function it_sets_the_weight()
    {
        $this->setWeight(3);
        $this->getWeight()->shouldReturn(3);
    }

    function it_throws_an_exception_when_setting_a_negative_weight()
    {
        $this
            ->shouldThrow(new \InvalidArgumentException('The weight must be a positive integer.'))
            ->duringSetWeight(-1)
        ;
    }
}
