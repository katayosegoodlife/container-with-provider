<?php

namespace Bellisq\ContainerWithProvider\Exceptions;

use LogicException;
use Psr\Container\NotFoundExceptionInterface;


/**
 * [ Exception ] Object Not Found
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class NotFoundException extends LogicException implements NotFoundExceptionInterface
{

    public function __construct()
    {
        parent::__construct('Object Not Found.');
    }

}
