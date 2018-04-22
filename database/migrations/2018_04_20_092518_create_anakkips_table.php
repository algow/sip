<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnakkipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anakkips', function (Blueprint $table) {
            $table->char('kode_satker', 6);
            $table->char('anak_satker', 6);
            $table->foreign('kode_satker')->references('kode')->on('satkers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anakkips');
    }
}
