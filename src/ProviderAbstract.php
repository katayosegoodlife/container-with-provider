<?php

namespace Bellisq\ContainerWithProvider;

use Bellisq\ContainerWithProvider\ObjectDefinitionRegister;


/**
 * [ Provider ] Abstract Provider
 * 
 * To deny multi-purpose classes, abstract class is provided instead of interface.
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
abstract class ProviderAbstract
{

    /**
     * [ Register ] Register what this class provides.
     * 
     * All providers must register what they provide in this method.
     */
    abstract public static function register(ObjectDefinitionRegister $odr);

    /**
     * [ Factory ]
     * 
     * Returns what this class provides.
     * 
     * Singleton mechanism is already implemented in container so that
     * instantiating is only required in this method.
     */
    abstract public function getInstance(string $name);
    
}
