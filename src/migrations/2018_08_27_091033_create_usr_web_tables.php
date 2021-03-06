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
            $table->string('nama_app',50);
            $table->string('namauser',25);
            $table->string('password');
            $table->string('tbl_sumber',30)->nullable();
            $table->integer('key_relasi')->nullable();
            $table->string('nama_lkp',50);
            $table->string('email_usr',50)->nullable();
            $table->tinyInteger('status');
            $table->integer('id_uaks')->default(0);
            $table->integer('rec_usr')->default(0);
            $table->timestamps();
            $table->rememberToken();
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
