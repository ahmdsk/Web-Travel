<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbldriver', function (Blueprint $table) {
            $table->id('id_driver');
            $table->foreignId('user_id')->constrained('tbluser')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tbldriver');
    }
}
