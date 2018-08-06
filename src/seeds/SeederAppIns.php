<?php

use Illuminate\Database\Seeder;

class SeederAppIns extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('app_ins')->insert([
            'instansi'=> 'STB',
            'ins_lkp' => 'Solusi Teknis Bandung',
            'ins_ing' => 'Solusi Teknis Bandung',
            'telp'    => '022-7569970',
            'alamat'    => 'Jl. Sekelimus 1 no 3',
            'kota'    => 'Kota Bandung',
            'prov'    => 'Jawa Barat',
            'kpos'    => '40266',
            'email'   => 'office@solusiteknis.co.id',        
            'logo_app'   => 'assets/image/logo/logo_app.png',       
            'logo_front'   => 'assets/image/logo/logo_front.png',        
            'logo_favicon'   => 'assets/image/logo/logo_favicon.ico',        
            ]);
    }
}
