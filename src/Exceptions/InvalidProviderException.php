<?php

namespace Bellisq\ContainerWithProvider\Exceptions;

use InvalidArgumentException;


/**
 * [ Exception ] Invalid Provider
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class InvalidProviderException extends InvalidArgumentException
{

    public function __construct()
    {
        parent::__construct('Invalid provider name is given.');
    }

}
