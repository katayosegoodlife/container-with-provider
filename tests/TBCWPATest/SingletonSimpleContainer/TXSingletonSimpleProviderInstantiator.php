<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer\TXSingletonSimpleProvider;


class TXSingletonSimpleProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        if ($className === TXSingletonSimpleProvider::class) {
            return new TXSingletonSimpleProvider;
        }
        return null;
    }

}
