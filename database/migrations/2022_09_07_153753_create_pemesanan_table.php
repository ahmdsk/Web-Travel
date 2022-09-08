<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblpemesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->integer('total_harga');
            $table->string('status_bayar');
            $table->date('tgl_perjalanan');
            $table->text('url_alamat')->nullable();
            $table->text('detail_penjemputan');
            $table->string('bukti_bayar');
            $table->integer('no_kursi');
            $table->foreignId('destinasi_id')->constrained('destinasi')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('penjemputan_id')->constrained('tblpenjemputan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('mobil_id')->constrained('tblmobil', 'id_mobil')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->constrained('tbluser')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tblpemesanan');
    }
}
