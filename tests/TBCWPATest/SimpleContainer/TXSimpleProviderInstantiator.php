<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleProvider;


class TXSimpleProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        return new $className;
    }

}
