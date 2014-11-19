<?php

namespace Unm\Laravel\Azure;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the Azure service
 */
class AzureFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'azure';
    }
}