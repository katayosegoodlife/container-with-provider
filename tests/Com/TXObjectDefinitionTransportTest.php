<?php

namespace Bellisq\ContainerWithProvider\Tests\Com;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\Com\ObjectDefinitionTransport;


class TXObjectDefinitionTransportTest extends TestCase
{

    private $odt;

    public function setUp()
    {
        $this->odt = new ObjectDefinitionTransport;
    }

    public function testBehavior()
    {
        $n = 'NAME';
        $t = 'TYPE';
        $this->odt->add($n, $t, true);
        $this->odt->add($n, $t, false);

        $this->assertEquals([
            [$n, $t, true],
            [$n, $t, false],
        ], $this->odt->get());
    }

}
