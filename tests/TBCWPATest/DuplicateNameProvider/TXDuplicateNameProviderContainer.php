<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider\TXDuplicateNameProvider;


class TXDuplicateNameProviderContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXDuplicateNameProvider::class);
        $pr->register(TXDuplicateNameProvider::class);
    }

}
