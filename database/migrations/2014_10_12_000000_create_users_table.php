<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbluser', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status_aktif');
            $table->string('role');
            $table->string('no_telp');
            $table->date('tgl_lahir');
            $table->string('foto')->nullable();
            $table->integer('umur')->nullable();
            $table->string('nik')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->text('url_alamat')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('tbluser');
    }
}
