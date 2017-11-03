<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider\TXInvalidObjectTypeProvider;


class TXInvalidObjectTypeProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        return new TXInvalidObjectTypeProvider;
    }

}
