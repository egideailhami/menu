<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_mnu');
            $table->string('app',20);
            $table->string('menu_ut',50);
            $table->integer('id_parent')->default(0);
            $table->tinyInteger('header')->default(0);
            $table->tinyInteger('divider')->default(0);
            $table->string('icon',20);
            $table->string('url',255)->nullable();
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
        Schema::dropIfExists('menu');
    }
}
