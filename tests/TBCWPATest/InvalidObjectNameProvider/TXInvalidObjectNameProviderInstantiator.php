<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider\TXInvalidObjectNameProvider;


class TXInvalidObjectNameProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        return new TXInvalidObjectNameProvider;
    }

}
