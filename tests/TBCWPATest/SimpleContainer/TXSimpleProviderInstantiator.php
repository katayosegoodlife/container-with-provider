<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleProvider;


class TXSimpleProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        if ($className === TXSimpleProvider::class) {
            return new TXSimpleProvider;
        }
        return null;
    }

}
