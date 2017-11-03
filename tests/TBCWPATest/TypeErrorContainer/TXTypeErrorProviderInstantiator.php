<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer;

use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer\TXTypeErrorProvider;


class TXTypeErrorProviderInstantiator implements InstantiatorInterface
{

    public function instantiate(string $className)
    {
        if ($className === TXTypeErrorProvider::class) {
            return new TXTypeErrorProvider;
        }
        return null;
    }

}
