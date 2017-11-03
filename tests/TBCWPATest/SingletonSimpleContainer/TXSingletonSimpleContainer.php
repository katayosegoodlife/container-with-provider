<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer\TXSingletonSimpleProvider;


class TXSingletonSimpleContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXSingletonSimpleProvider::class);
    }

}
