<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleProviderQuickLoad;


class TXSimpleContainerQuickLoad extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXSimpleProviderQuickLoad::class, true);
    }

}
