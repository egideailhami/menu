<?php

namespace GritTekno\Menu;

use Illuminate\Support\Facades\Facade;

/**
 *
 */
class MenuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'grittekno.menu';
    }
}
