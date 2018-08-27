<?php
namespace Egideailhami\Menu\Seeds;

use Illuminate\Database\Seeder;
use Egideailhami\Menu\Models\Menu;
use Egideailhami\Menu\Models\UsrWeb;

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

        $usr_web = new UsrWeb;
        $usr_web->namauser = 'admin';
        $usr_web->password = bcrypt('20tekNo17');
        $usr_web->tbl_sumber = 'karyawan';
        $usr_web->key_relasi = '5';
        $usr_web->nama_lkp = 'Egi Dea Ilhami';
        $usr_web->email_usr = 'egideailhami@gmail.com';
        $usr_web->status = 1;
        $usr_web->save();
    }
}
