<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer\TXTypeErrorClass;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer\TXTypeErrorClassParent;


class TXTypeErrorProvider extends ProviderAbstract
{

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('typeErrorObj', TXTypeErrorClass::class);
    }

    public function getInstance(string $name)
    {
        if ($name === 'typeErrorObj') {
            return new TXTypeErrorClassParent;
        }
        return null;
    }

}
