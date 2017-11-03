<?php

namespace Bellisq\ContainerWithProvider;

use Bellisq\ContainerWithProvider\Com\ProviderTransport;


/**
 * [ Communication ] Provider Register
 * 
 * This class lets containers register their providers
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
class ProviderRegister
{

    private $pt;

    public function __construct(ProviderTransport $pt)
    {
        $this->pt = $pt;
    }

    public function register(string $name, bool $quickLoad = false): self
    {
        $this->pt->add($name, $quickLoad);
        return $this;
    }

}
