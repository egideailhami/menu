<?php

use Illuminate\Database\Seeder;
use Egideailhami\Menu\Models\Menu;
use Egideailhami\Menu\Models\UsrWeb;
use Egideailhami\Menu\Models\AksesHak;

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
        $menu->app = env('nama_app');
        $menu->menu_ut = 'Settings';
        $menu->id_parent = 0;
        $menu->icon = 'fa fa-gears';
        $menu->url = '';
        $menu->save();

        
        $menu = new Menu;
        $menu->app = env('nama_app');
        $menu->menu_ut = 'Menu';
        $menu->id_parent = Menu::where('menu_ut','Settings')->first()->id_mnu;
        $menu->icon = 'fa fa-bars';
        $menu->url = env('menu_url');
        $menu->save();

        $usr_web = new UsrWeb;
        $usr_web->namauser = 'superuser';
        $usr_web->nama_app = env('nama_app');
        $usr_web->password = bcrypt('20tekNo17');
        $usr_web->nama_lkp = 'Super User';
        $usr_web->email_usr = 'egideailhami@gmail.com';
        $usr_web->status = 1;
        $usr_web->save();

        $usr_hak = new AksesHak;
        $usr_hak->jns_hak = 'superuser';
        $usr_hak->nama_app = env('nama_app');
        $usr_hak->ket_akses = 'Super User';
        $usr_hak->save();

        DB::table('app_ins')->insert([
            'nama_app'=>env('nama_app'),
            'instansi'=>'BPMSP',
            'ins_lkp'=>'Balai Pengujian Mutu dan Sertifikasi Pakan',
            'ins_ing'=>'Feed Quality and Certification Assay Centre',
            'alamat'=>'Jl. MT. Haryono No. 98 Kecamatan Setu',
            'telp'=>'021826602182',
            'fax'=>'021826607499',
            'kota'=>'Kabupaten Bekasi',
            'kpos'=>'17320',
            'prov'=>'Jawa Barat',
            'website'=>'http://bpmsp.ditjenpkh.pertanian.go.id',
            'email'=>'bpmsp@pertanian.go.id',
            'logo_app'=>'assets/images/logo/logo_app.png',
            'logo_dok'=>'assets/images/logo/logo_dok.png',
            'logo_front'=>'assets/images/logo/logo_front.png',
            'logo_favicon'=>'assets/images/logo/logo_favicon.ico',
            'jns_kan'=>'Laboratorium Penguji',
            'no_kan'=>'LP-172-IDN',
        ]);
    }
}
