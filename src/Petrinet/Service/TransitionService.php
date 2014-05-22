<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Service;

use Petrinet\Model\FactoryInterface;
use Petrinet\Model\MarkingInterface;
use Petrinet\Model\TransitionInterface;
use Petrinet\Service\Exception\TransitionNotEnabledException;

/**
 * Implementation of the TransitionServiceInterface.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TransitionService implements TransitionServiceInterface
{
    /**
     * The factory.
     *
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Creates a new transition service.
     *
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled(TransitionInterface $transition, MarkingInterface $marking)
    {
        $inputArcs = $transition->getInputArcs();

        if (empty($inputArcs)) {
            return false;
        }

        foreach ($inputArcs as $inputArc) {
            $place = $inputArc->getPlace();
            $placeMarking = $marking->getPlaceMarking($place);

            if (null === $placeMarking) {
                return false;
            }

            if (count($placeMarking->getTokens()) < $inputArc->getWeight()) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function fire(TransitionInterface $transition, MarkingInterface $marking)
    {
        if (!$this->isEnabled($transition, $marking)) {
            throw new TransitionNotEnabledException('Cannot fire a disabled transition.');
        }

        $inputArcs = $transition->getInputArcs();
        $outputArcs = $transition->getOutputArcs();

        // Remove tokens from the input places
        foreach ($inputArcs as $arc) {
            $arcWeight = $arc->getWeight();
            $place = $arc->getPlace();
            $placeMarking = $marking->getPlaceMarking($place);
            $tokens = $placeMarking->getTokens();

            for ($i = 0; $i < $arcWeight; $i++) {
                $placeMarking->removeToken($tokens[$i]);
            }
        }

        // Add tokens to the output places
        foreach ($outputArcs as $arc) {
            $arcWeight = $arc->getWeight();
            $place = $arc->getPlace();
            $placeMarking = $marking->getPlaceMarking($place);

            if (null === $placeMarking) {
                $placeMarking = $this->factory->createPlaceMarking();
                $placeMarking->setPlace($place);
                $marking->addPlaceMarking($placeMarking);
            }

            // Create the tokens
            $tokens = array();
            for ($i = 0; $i < $arcWeight; $i++) {
                $tokens[] = $this->factory->createToken();
            }

            $placeMarking->setTokens($tokens);
        }
    }
}
