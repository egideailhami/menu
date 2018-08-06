<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppIns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_ins', function (Blueprint $table) {
            $table->increments('id_ai');
            $table->string('instansi',100);
            $table->string('ins_lkp',100)->nullable();
            $table->string('ins_ing',100)->nullable();
            $table->string('alamat',255)->nullable();
            $table->string('telp',20)->nullable();
            $table->string('fax',20)->nullable();
            $table->string('kota',50);
            $table->char('kpos',5);
            $table->string('prov',50);
            $table->string('website',50)->nullable();
            $table->string('email',50)->nullable();
            $table->string('jns_kan',255)->nullable();
            $table->string('no_kan',255)->nullable();
            $table->string('logo_app',255)->nullable();
            $table->string('logo_dok',255)->nullable();
            $table->string('logo_front',255)->nullable();
            $table->string('logo_favicon',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_ins');
    }
}
