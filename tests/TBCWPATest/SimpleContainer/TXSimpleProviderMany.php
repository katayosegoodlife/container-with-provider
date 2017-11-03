<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClass;


class TXSimpleProviderMany extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('simpleObj1', TXSimpleClass::class);
        $odr->register('simpleObj2', TXSimpleClass::class);
    }

    public function getInstance(string $name)
    {
        return new TXSimpleClass;
    }

}
