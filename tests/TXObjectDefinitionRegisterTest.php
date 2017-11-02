<?php

namespace Bellisq\ContainerWithProvider\Tests;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;
use Bellisq\ContainerWithProvider\Com\ObjectDefinitionTransport;


class TXObjectDefinitionRegisterTest extends TestCase
{

    private $odt;
    private $odr;

    public function setUp()
    {
        $this->odr = new ObjectDefinitionRegister(
            $this->odt = new ObjectDefinitionTransport
        );
    }

    public function testBehavior()
    {
        $n = 'NAME';
        $t = 'TYPE';
        $this->odr->registerAsSingleton($n, $t);
        $this->odr->register($n, $t);

        $this->assertEquals([
            [$n, $t, true],
            [$n, $t, false],
            ], $this->odt->get());
    }

}
