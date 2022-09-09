<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblrating', function (Blueprint $table) {
            $table->id();
            $table->string('rating');
            $table->text('keterangan')->nullable();
            $table->foreignId('id_pesanan')->constrained('tblpemesanan', 'id_pesanan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_user')->constrained('tbluser')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tblrating');
    }
}
