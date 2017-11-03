<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\ProviderClassValidator;
use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClass;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClassParent;
use Bellisq\ContainerWithProvider\Exceptions\NotFoundException;


class TXTypeBasedContainerWithProviderAbstractTest extends TestCase
{

    private $simpleContainer;

    public function setUp()
    {
        $this->simpleContainer = new TXSimpleContainer(new ProviderClassValidator(ProviderAbstract::class), new TXSimpleProviderInstantiator);
    }

    public function testSimpleContainer()
    {
        $sc = $this->simpleContainer;
        $this->assertInstanceOf(TXSimpleClass::class, $sc->get('simpleObj', TXSimpleClass::class));
        $this->assertInstanceOf(TXSimpleClass::class, $sc->get('simpleObj'));
        $this->assertInstanceOf(TXSimpleClass::class, $sc->get('334', TXSimpleClass::class));
        $this->assertInstanceOf(TXSimpleClass::class, $sc->get('simpleObj', TXSimpleClassParent::class));
        $this->assertInstanceOf(TXSimpleClass::class, $sc->get('334', TXSimpleClassParent::class));
    }

    public function testSimpleContainerFail1()
    {
        $sc = $this->simpleContainer;
        $this->expectException(NotFoundException::class);
        $sc->get('334');
    }

    public function testSimpleContainerFail2()
    {
        $sc = $this->simpleContainer;
        $this->expectException(NotFoundException::class);
        $sc->get('simpleObj', 'INVALID_CLASS');
    }

    public function testSimpleContainerFail3()
    {
        $sc = $this->simpleContainer;
        $this->expectException(NotFoundException::class);
        $sc->get(null, 'INVALID_CLASS');
    }

}
