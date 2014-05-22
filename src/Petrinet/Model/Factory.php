<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Model;

/**
 * Implementation of FactoryInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class Factory implements FactoryInterface
{
    private $petrinetClass;
    private $placeClass;
    private $transitionClass;
    private $inputArcClass;
    private $outputArcClass;
    private $placeMarkingClass;
    private $tokenClass;
    private $markingClass;

    /**
     * Creates a new factory.
     *
     * @param string $petrinetClass
     * @param string $placeClass
     * @param string $transitionClass
     * @param string $inputArcClass
     * @param string $outputArcClass
     * @param string $placeMarkingClass
     * @param string $tokenClass
     * @param string $markingClass
     */
    public function __construct(
        $petrinetClass = 'Petrinet\Model\Petrinet',
        $placeClass = 'Petrinet\Model\Place',
        $transitionClass = 'Petrinet\Model\Transition',
        $inputArcClass = 'Petrinet\Model\InputArc',
        $outputArcClass = 'Petrinet\Model\OutputArc',
        $placeMarkingClass = 'Petrinet\Model\PlaceMarking',
        $tokenClass = 'Petrinet\Model\Token',
        $markingClass = 'Petrinet\Model\Marking'
    ) {
        $this->petrinetClass = $petrinetClass;
        $this->placeClass = $placeClass;
        $this->transitionClass = $transitionClass;
        $this->inputArcClass = $inputArcClass;
        $this->outputArcClass = $outputArcClass;
        $this->placeMarkingClass = $placeMarkingClass;
        $this->tokenClass = $tokenClass;
        $this->markingClass = $markingClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createPetrinet()
    {
        $petrinet = new $this->petrinetClass();

        if (!$petrinet instanceof PetrinetInterface) {
            throw new \RuntimeException('The Petrinet class must implement "Petrinet\Model\PetrinetInterface".');
        }

        return $petrinet;
    }

    /**
     * {@inheritdoc}
     */
    public function createPlace()
    {
        $place = new $this->placeClass();

        if (!$place instanceof PlaceInterface) {
            throw new \RuntimeException('The place class must implement "Petrinet\Model\PlaceInterface".');
        }

        return $place;
    }

    /**
     * {@inheritdoc}
     */
    public function createTransition()
    {
        $transition = new $this->transitionClass();

        if (!$transition instanceof TransitionInterface) {
            throw new \RuntimeException('The transition class must implement "Petrinet\Model\TransitionInterface".');
        }

        return $transition;
    }

    /**
     * {@inheritdoc}
     */
    public function createInputArc()
    {
        $arc = new $this->inputArcClass();

        if (!$arc instanceof InputArcInterface) {
            throw new \RuntimeException('The input arc class must implement "Petrinet\Model\InputArcInterface".');
        }

        return $arc;
    }

    /**
     * {@inheritdoc}
     */
    public function createOutputArc()
    {
        $arc = new $this->outputArcClass();

        if (!$arc instanceof OutputArcInterface) {
            throw new \RuntimeException('The output arc class must implement "Petrinet\Model\OutputArcInterface".');
        }

        return $arc;
    }

    /**
     * {@inheritdoc}
     */
    public function createPlaceMarking()
    {
        $placeMarking = new $this->placeMarkingClass();

        if (!$placeMarking instanceof PlaceMarkingInterface) {
            throw new \RuntimeException(
                'The place marking class must implement "Petrinet\Model\PlaceMarkingInterface".'
            );
        }

        return $placeMarking;
    }

    /**
     * {@inheritdoc}
     */
    public function createToken()
    {
        $token = new $this->tokenClass();

        if (!$token instanceof TokenInterface) {
            throw new \RuntimeException('The token class must implement "Petrinet\Model\TokenInterface".');
        }

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function createMarking()
    {
        $marking = new $this->markingClass();

        if (!$marking instanceof MarkingInterface) {
            throw new \RuntimeException('The marking class must implement "Petrinet\Model\MarkingInterface".');
        }

        return $marking;
    }
}
