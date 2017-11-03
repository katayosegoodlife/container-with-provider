<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;


class TXDuplicateNameProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        
    }

    public function getInstance(string $name)
    {
        return 1;
    }

}
