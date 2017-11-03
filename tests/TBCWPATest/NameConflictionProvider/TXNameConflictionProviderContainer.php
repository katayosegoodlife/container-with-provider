<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider\TXNameConflictionProvider;


class TXNameConflictionProviderContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXNameConflictionProvider::class);
    }

}
