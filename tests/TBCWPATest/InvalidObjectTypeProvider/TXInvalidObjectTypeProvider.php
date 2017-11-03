<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;


class TXInvalidObjectTypeProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('invTypeObj', 'class');
    }

    public function getInstance(string $name)
    {
        return 1;
    }

}
