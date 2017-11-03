<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider\TXNameConflictionProvider;


class TXNameConflictionProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        return new TXNameConflictionProvider;
    }

}
