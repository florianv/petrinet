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
 * The factory is the place where model instances are created.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
interface FactoryInterface
{
    /**
     * Creates a new Petrinet instance.
     *
     * @return PetrinetInterface
     */
    public function createPetrinet();

    /**
     * Creates a new place instance.
     *
     * @return PlaceInterface
     */
    public function createPlace();

    /**
     * Creates a new transition instance.
     *
     * @return PlaceInterface
     */
    public function createTransition();

    /**
     * Creates a new input arc instance.
     *
     * @return InputArcInterface
     */
    public function createInputArc();

    /**
     * Creates a new output arc instance.
     *
     * @return OutputArcInterface
     */
    public function createOutputArc();

    /**
     * Creates a new place marking instance.
     *
     * @return PlaceMarkingInterface
     */
    public function createPlaceMarking();

    /**
     * Creates a new token instance.
     *
     * @return TokenInterface
     */
    public function createToken();

    /**
     * Creates a new marking instance.
     *
     * @return MarkingInterface
     */
    public function createMarking();
}
