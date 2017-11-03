<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;


class TXInvalidObjectNameProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('INVALID?NAME', 'class_name');
    }

    public function getInstance(string $name)
    {
        return 1;
    }

}
