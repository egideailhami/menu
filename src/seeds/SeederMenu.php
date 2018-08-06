<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class SeederMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = new Menu;
        $menu->app = env('menu_app');
        $menu->menu_ut = 'Settings';
        $menu->id_parent = 0;
        $menu->icon = 'fa fa-gears';
        $menu->url = '';
        $menu->save();

        
        $menu = new Menu;
        $menu->app = env('menu_app');
        $menu->menu_ut = 'Menu';
        $menu->id_parent = Menu::where('menu_ut','Settings')->first()->id_mnu;
        $menu->icon = 'fa fa-bars';
        $menu->url = env('menu_url');
        $menu->save();
    }
}
