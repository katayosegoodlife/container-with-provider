<?php

namespace Bellisq\ContainerWithProvider\Exceptions;

use LogicException;
use Psr\Container\ContainerExceptionInterface;


/**
 * [ Exception ] Too Many Candidates
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class TooManyCandidatesException extends LogicException implements ContainerExceptionInterface
{

    public function __construct()
    {
        parent::__construct('Too many candidates found. Specify name and type-hint');
    }

}
