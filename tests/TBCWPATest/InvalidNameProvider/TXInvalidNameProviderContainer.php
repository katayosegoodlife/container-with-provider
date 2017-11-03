<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidNameProvider;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;


class TXInvalidNameProviderContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register('INVALID?CLASS');
    }

}
