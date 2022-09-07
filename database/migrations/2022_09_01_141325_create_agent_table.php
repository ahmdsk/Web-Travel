<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblagent', function (Blueprint $table) {
            $table->id('id_agent');
            $table->foreignId('user_id')->constrained('tbluser')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('perusahaan_id')->constrained('tblperusahaan', 'id_perusahaan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblagent');
    }
}
