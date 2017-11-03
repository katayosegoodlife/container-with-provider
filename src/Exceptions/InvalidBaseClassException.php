<?php

namespace Bellisq\ContainerWithProvider\Exceptions;

use DomainException;


class InvalidBaseClassException extends DomainException
{

    public function __construct()
    {
        parent::__construct('Base Class must be a type of ProviderAbstract.');
    }

}
