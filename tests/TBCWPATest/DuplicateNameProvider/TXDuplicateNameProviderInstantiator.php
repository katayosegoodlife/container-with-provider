<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider\TXDuplicateNameProviderContainer;


class TXDuplicateNameProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        return new TXDuplicateNameProviderContainer;
    }

}
