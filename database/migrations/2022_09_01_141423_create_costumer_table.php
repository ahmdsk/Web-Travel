<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostumerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblcostumer', function (Blueprint $table) {
            $table->id('id_costumer');
            $table->foreignId('user_id')->constrained('tbluser');
            $table->foreignId('perusahaan_id')->constrained('tblperusahaan', 'id_perusahaan');
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
        Schema::dropIfExists('tblcostumer');
    }
}
