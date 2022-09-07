<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblmobil', function (Blueprint $table) {
            $table->id('id_mobil');
            $table->string('no_polisi');
            $table->string('merk_mobil');
            $table->string('warna_mobil');
            $table->string('foto_mobil');
            $table->string('fasilitas');
            $table->integer('jumlah_kursi');
            $table->foreignId('driver_id')->constrained('tbldriver', 'id_driver')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('perusahaan_id')->constrained('tblperusahaan', 'id_perusahaan')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tblmobil');
    }
}
