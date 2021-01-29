<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListVillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_villas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_villa');
            $table->string('nama_pemilik');
            $table->string('luas_villa');
            $table->string('lokasi_villa');
            $table->string('kawasan');
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
        Schema::dropIfExists('list_villas');
    }
}
