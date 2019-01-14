<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration
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
            $table->string('nama_app',50);
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
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id_mnu');
            $table->string('app',20);
            $table->string('menu_ut',50);
            $table->integer('id_parent')->default(0);
            $table->tinyInteger('header')->default(0);
            $table->tinyInteger('divider')->default(0);
            $table->Integer('urut')->default(100);
            $table->string('icon',20);
            $table->string('url',255)->nullable();
            $table->string('routename',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

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

        Schema::create('akses_hak', function (Blueprint $table) {
            $table->increments('id_akk');
            $table->string('jns_hak',20);
            $table->string('ket_hak',20);
            $table->integer('rec_usr')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('akses_usr', function (Blueprint $table) {
            $table->increments('id_uaks');
            $table->string('nama_app',50);
            $table->string('usr_akses',150);
            $table->string('ket_akses',150)->nullable();
            $table->integer('rec_usr')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

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

        Schema::create('usr_log', function (Blueprint $table) {
            $table->increments('id_log');
            $table->string('nama_app',50);
            $table->integer('id_usr');
            $table->string('tabel',20);
            $table->string('idval',20);
            $table->string('ket',20);
            $table->timestamps();
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
        Schema::dropIfExists('menu');
        Schema::dropIfExists('akses_det');
        Schema::dropIfExists('akses_hak');
        Schema::dropIfExists('akses_usr');
        Schema::dropIfExists('usr_log');
    }
}
