<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidNameProvider;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidNameProvider\TXInvalidNameProvider;


class TXInvalidNameProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        return new TXInvalidNameProvider;
    }

}
