<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer;

use Bellisq\ContainerWithProvider\TypeBasedContainerWithProviderAbstract;
use Bellisq\ContainerWithProvider\ProviderRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer\TXTypeErrorProvider;


class TXTypeErrorContainer extends TypeBasedContainerWithProviderAbstract
{

    public static function registerProviders(ProviderRegister $pr): void
    {
        $pr->register(TXTypeErrorProvider::class);
    }

}
