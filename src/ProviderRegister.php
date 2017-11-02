<?php

namespace Bellisq\ContainerWithProvider;

use Bellisq\ContainerWithProvider\Com\ProviderTransport;


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
