<?php

namespace Bellisq\ContainerWithProvider;

use Bellisq\ContainerWithProvider\Com\ObjectDefinitionTransport;


/**
 * [ Communication ] Object Definition Register
 * 
 * This class lets providers register their objects
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class ObjectDefinitionRegister
{

    private $odt;

    public function __construct(ObjectDefinitionTransport $odt)
    {
        $this->odt = $odt;
    }

    public function register(string $name, string $type): self
    {
        $this->odt->add($name, $type, false);
        return $this;
    }

    public function registerAsSingleton(string $name, string $type): self
    {
        $this->odt->add($name, $type, true);
        return $this;
    }

}
