<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAksesDetTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_det', function (Blueprint $table) {
            $table->increments('id_uad');
            $table->integer('id_uaks');
            $table->integer('id_mnu');
            $table->integer('id_akk');
            $table->tinyInteger('all_view')->default(1);
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
        Schema::dropIfExists('akses_det');
    }
}
