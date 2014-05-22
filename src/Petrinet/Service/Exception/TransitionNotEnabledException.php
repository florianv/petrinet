<?php

/*
 * This file is part of the Petrinet framework.
 *
 * (c) Florian Voutzinos <florian@voutzinos.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Petrinet\Service\Exception;

/**
 * Exception thrown when trying to fire a disabled transition.
 *
 * @author Florian Voutzinos <florian@voutzinos.com>
 */
class TransitionNotEnabledException extends \RuntimeException
{
}
