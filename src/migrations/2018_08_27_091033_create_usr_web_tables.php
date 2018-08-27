<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsrWebTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usr_web', function (Blueprint $table) {
            $table->increments('id_usr');
            $table->string('namauser',25);
            $table->string('password');
            $table->string('tbl_sumber',30);
            $table->integer('key_relasi');
            $table->string('nama_lkp',50);
            $table->string('email_usr',50);
            $table->tinyInteger('status');
            $table->integer('id_uaks')->default(0);
            $table->integer('rec_usr')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usr_web');        
    }
}
