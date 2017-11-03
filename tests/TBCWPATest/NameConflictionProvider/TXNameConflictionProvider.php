<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;


class TXNameConflictionProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('valid_name', 'class_name');
        $odr->register('valid_name', 'class_name');
    }

    public function getInstance(string $name)
    {
        return 1;
    }

}
