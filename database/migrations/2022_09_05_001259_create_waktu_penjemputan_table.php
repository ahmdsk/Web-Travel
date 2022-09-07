<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaktuPenjemputanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblwaktu_penjemputan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjemputan')->constrained('tblpenjemputan')->onDelete('cascade')->onUpdate('cascade');
            $table->string('waktu_penjemputan');
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
        Schema::dropIfExists('tblwaktu_penjemputan');
    }
}
