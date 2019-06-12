<?php

namespace trespixel\framework\Facades;

use Illuminate\Support\Facades\Facade;

class framework extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'framework';
    }
}
