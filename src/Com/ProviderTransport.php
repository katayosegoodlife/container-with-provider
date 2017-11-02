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
class ProviderTransport
{

    private $data = [];

    public function add(string $providerClassName, bool $quickLoad)
    {
        $this->data[] = [$providerClassName, $quickLoad];
    }

    public function get(): array
    {
        return $this->data;
    }

}
