<?php

namespace Bellisq\ContainerWithProvider\Exceptions;

use LogicException;


/**
 * [ Exception ] Invalid Object Name
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class ObjectTypeErrorException extends LogicException
{

    public function __construct()
    {
        parent::__construct('The type of object returned by provider does not match with declared type');
    }

}
