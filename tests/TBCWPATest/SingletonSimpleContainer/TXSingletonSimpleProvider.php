<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer\TXSingletonSimpleClass;


class TXSingletonSimpleProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->registerAsSingleton('singletonSimpleObj', TXSingletonSimpleClass::class);
    }

    public function getInstance(string $name)
    {
        if ($name === 'singletonSimpleObj') {
            return new TXSingletonSimpleClass;
        }

        return null;
    }

}
