<?php

namespace Bellisq\ContainerWithProvider\Com;


/**
 * [ Communication ] Data Transporter
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
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
