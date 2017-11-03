<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClass;


class TXSimpleProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('simpleObj', TXSimpleClass::class);
    }

    public function getInstance(string $name)
    {
        if ($name === 'simpleObj') {
            return new TXSimpleClass;
        }
        return null;
    }

}
