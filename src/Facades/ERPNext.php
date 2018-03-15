<?php

namespace Hammock\LaravelERPNext\Facades;

use Illuminate\Support\Facades\Facade;

class ERPNext extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'erpnext';
    }
}
