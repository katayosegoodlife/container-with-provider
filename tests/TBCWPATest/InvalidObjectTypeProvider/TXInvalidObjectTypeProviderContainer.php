<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider;
use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider\TXInvalidObjectTypeProvider;


class TXInvalidObjectTypeProviderContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXInvalidObjectTypeProvider::class);
    }

}
