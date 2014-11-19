<?php

namespace Chew\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Azure service
 */
class AzureLive extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'azurelive';
    }
}