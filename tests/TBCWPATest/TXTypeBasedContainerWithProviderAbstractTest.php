<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\ProviderClassValidator;
use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClass;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClassParent;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidNameProvider\TXInvalidNameProviderContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidNameProvider\TXInvalidNameProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider\TXDuplicateNameProviderContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\DuplicateNameProvider\TXDuplicateNameProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider\TXInvalidObjectNameProviderContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectNameProvider\TXInvalidObjectNameProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider\TXInvalidObjectTypeProviderContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\InvalidObjectTypeProvider\TXInvalidObjectTypeProviderInstantiator;
use Bellisq\Validator\General\SubclassValidator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider\TXNameConflictionProviderContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\NameConflictionProvider\TXNameConflictionProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer\TXTypeErrorContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\TypeErrorContainer\TXTypeErrorProviderInstantiator;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer\TXSingletonSimpleContainer;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SingletonSimpleContainer\TXSingletonSimpleProviderInstantiator;
use Bellisq\ContainerWithProvider\Exceptions\{
    NotFoundException,
    InvalidProviderException,
    DuplicateProviderException,
    InvalidObjectNameException,
    InvalidObjectTypeException,
    ObjectNameConflictionException,
    ObjectTypeErrorException
};


class TXTypeBasedContainerWithProviderAbstractTest extends TestCase
{

    private $simpleContainer;

    public function setUp()
    {
        $this->simpleContainer = new TXSimpleContainer(new TXSimpleProviderInstantiator);
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

    public function testInvalidNameProvider()
    {
        $this->expectException(InvalidProviderException::class);
        new TXInvalidNameProviderContainer(new TXInvalidNameProviderInstantiator);
    }

    public function testDuplicateNameProvider()
    {
        $this->expectException(DuplicateProviderException::class);
        new TXDuplicateNameProviderContainer(new TXDuplicateNameProviderInstantiator);
    }

    public function testInvalidObjectName()
    {
        $this->expectException(InvalidObjectNameException::class);
        new TXInvalidObjectNameProviderContainer(new TXInvalidObjectNameProviderInstantiator);
    }

    public function testInvalidObjectType()
    {
        $this->expectException(InvalidObjectTypeException::class);
        new TXInvalidObjectTypeProviderContainer(new TXInvalidObjectTypeProviderInstantiator, null, new SubclassValidator(TestCase::class));
    }

    public function testNameConfliction()
    {
        $this->expectException(ObjectNameConflictionException::class);
        new TXNameConflictionProviderContainer(new TXNameConflictionProviderInstantiator);
    }

    public function testTypeError()
    {
        $this->expectException(ObjectTypeErrorException::class);
        $t = new TXTypeErrorContainer(new TXTypeErrorProviderInstantiator);
        $t->get('typeErrorObj');
    }

    public function testFactory()
    {
        $sc = $this->simpleContainer;
        $this->assertTrue($sc->get('simpleObj') == $sc->get('simpleObj'));
        $this->assertFalse($sc->get('simpleObj') === $sc->get('simpleObj'));
    }

    public function testSingleton()
    {
        $sc = new TXSingletonSimpleContainer(new TXSingletonSimpleProviderInstantiator);
        $this->assertTrue($sc->get('singletonSimpleObj') == $sc->get('singletonSimpleObj'));
        $this->assertTrue($sc->get('singletonSimpleObj') === $sc->get('singletonSimpleObj'));
    }

}
