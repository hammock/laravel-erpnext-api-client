<?php

namespace Hammock\LaravelERPNext;

use Hammock\LaravelERPNext\Configuration\ConfigurationInterface;

class ERPNextClient
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    public function __construct(ConfigurationInterface $config)
    {
        $this->config = $config;
    }
}
