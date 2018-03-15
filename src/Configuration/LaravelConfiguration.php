<?php

namespace Hammock\LaravelERPNext\Configuration;

class LaravelConfiguration extends AbstractConfiguration
{
    public function __construct()
    {
        $this->domain = config('erpnext.domain');
        $this->user = config('erpnext.user');
        $this->password = config('erpnext.password');
    }
}
