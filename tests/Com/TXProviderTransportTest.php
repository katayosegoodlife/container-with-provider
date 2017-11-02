<?php

namespace Bellisq\ContainerWithProvider\Tests\Com;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\Com\ProviderTransport;


class TXProviderTransportTest extends TestCase
{

    private $pt;

    public function setUp()
    {
        $this->pt = new ProviderTransport;
    }

    public function testBehavior()
    {
        $n = 'CN';
        $this->pt->add($n, true);
        $this->pt->add($n, false);

        $this->assertEquals([
            [$n, true],
            [$n, false]
        ], $this->pt->get());
    }

}
