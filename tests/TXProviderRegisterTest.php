<?php

namespace Bellisq\ContainerWithProvider\Tests;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\Com\ProviderTransport;
use Bellisq\ContainerWithProvider\ProviderRegister;


class TXProviderRegisterTest extends TestCase
{

    private $pt, $pr;

    public function setUp()
    {
        $this->pt = new ProviderTransport;
        $this->pr = new ProviderRegister($this->pt);
    }

    public function testBehavior()
    {
        $n = 'CN';
        $this->pr
            ->register($n)
            ->register($n, false)
            ->register($n, true);

        $this->assertEquals([
            [$n, false],
            [$n, false],
            [$n, true]
        ], $this->pt->get());
    }

}
