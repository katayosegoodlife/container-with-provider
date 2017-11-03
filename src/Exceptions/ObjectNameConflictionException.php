<?php

namespace Bellisq\ContainerWithProvider\Exceptions;

use DomainException;


/**
 * [ Exception ] Object Name Confliction
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class ObjectNameConflictionException extends DomainException
{

    public function __construct()
    {
        parent::__construct('Object name conflicted.');
    }

}
