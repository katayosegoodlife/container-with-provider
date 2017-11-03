<?php

namespace Bellisq\ContainerWithProvider;

use Bellisq\Validator\General\SubclassValidator;
use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\Exceptions\InvalidBaseClassException;


/**
 * [ Validator ] Provider Class Validator
 * 
 * In addition to SubclassValidator, base class must be a type of ProviderAbstract.
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
final class ProviderClassValidator extends SubclassValidator
{

    public function __construct(?string $baseClassName = null)
    {
        if (is_null($baseClassName)) {
            $baseClassName = ProviderAbstract::class;
        }
        if (!is_a($baseClassName, ProviderAbstract::class, true)) {
            throw new InvalidBaseClassException;
        }
        parent::__construct($baseClassName);
    }

}
