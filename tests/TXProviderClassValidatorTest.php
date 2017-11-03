<?php

namespace Bellisq\ContainerWithProvider\Tests;

use PHPUnit\Framework\TestCase;
use Bellisq\ContainerWithProvider\ProviderClassValidator;
use Bellisq\ContainerWithProvider\Exceptions\InvalidBaseClassException;
use Bellisq\ContainerWithProvider\ProviderAbstract;

class TXProviderClassValidatorTest extends TestCase
{

    public function testInvalidBaseClass()
    {
        $this->expectException(InvalidBaseClassException::class);
        new ProviderClassValidator(TestCase::class);
    }

    public function testBehavior()
    {
        $pcv = new ProviderClassValidator;
        $this->assertTrue($pcv->validate(TXProviderClassMock::class));
        $this->assertFalse($pcv->validate(ProviderAbstract::class));
        $this->assertFalse($pcv->validate(TestCase::class));
    }
    
    public function testBehavior2()
    {
        $pcv = new ProviderClassValidator(TXProviderClassMock::class);
        $this->assertTrue($pcv->validate(TXProviderClassMockChild::class));
        $this->assertFalse($pcv->validate(TXProviderClassMock::class));
        $this->assertFalse($pcv->validate(TestCase::class));
    }

}

abstract class TXProviderClassMock extends ProviderAbstract { }
abstract class TXProviderClassMockChild extends TXProviderClassMock {}