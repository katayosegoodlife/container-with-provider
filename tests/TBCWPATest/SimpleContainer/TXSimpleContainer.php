<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleProvider;


class TXSimpleContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXSimpleProvider::class);
    }

}
