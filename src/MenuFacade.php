<?php

namespace Egideailhami\Menu;

use Illuminate\Support\Facades\Facade;

/**
 *
 */
class MenuFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'egideailhami.menu';
    }
}
