<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider\TXInvalidObjectNameProvider;


class TXInvalidObjectNameProviderContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXInvalidObjectNameProvider::class);
    }

}
