<?php

namespace Amyisme13\UltraHelper;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Amyisme13\UltraHelper\UltraHelper
 */
class UltraHelperFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ultra-helper';
    }
}
