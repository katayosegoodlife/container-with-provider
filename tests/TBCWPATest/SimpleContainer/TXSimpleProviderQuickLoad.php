<?php

namespace Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer;

use Bellisq\ContainerWithProvider\ProviderAbstract;
use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;
use Bellisq\ContainerWithProvider\Tests\TBCWPATest\SimpleContainer\TXSimpleClass;


class TXSimpleProviderQuickLoad extends ProviderAbstract
{

    private static $loaded = false;

    public function __construct()
    {
        self::$loaded = true;
    }

    public static function isLoaded(): bool
    {
        return self::$loaded;
    }

    public static function register(ObjectDefinitionRegister $odr): void
    {
        $odr->register('simpleObj', TXSimpleClass::class);
    }

    public function getInstance(string $name)
    {
        if ($name === 'simpleObj') {
            return new TXSimpleClass;
        }
        return null;
    }

}
