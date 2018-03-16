<?php

namespace Hammock\LaravelERPNext\Configuration;

use Illuminate\Support\Facades\Config;

/**
 * Class LaravelConfiguration
 *
 * @package Hammock\LaravelERPNext\Configuration
 */
class LaravelConfiguration extends AbstractConfiguration
{
    public function __construct()
    {
        $this->domain = Config::get('erpnext.domain');
        $this->user = Config::get('erpnext.user');
        $this->password = Config::get('erpnext.password');
    }
}
