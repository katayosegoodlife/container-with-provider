<?php

namespace Bellisq\ContainerWithProvider\Com;

class ObjectDefinitionTransport
{

    private $data = [];

    public function add(string $name, string $type, bool $isSingleton)
    {
        $this->data[] = [$name, $type, $isSingleton];
    }

    public function get(): array
    {
        return $this->data;
    }

}
