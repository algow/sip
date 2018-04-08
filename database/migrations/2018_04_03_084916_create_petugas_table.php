<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->string('barcode', 32)->primary();
            $table->char('kode_satker');
            $table->string('nip', 18);
            $table->boolean('aktif')->default(1);
            $table->string('nama_petugas', 48);
            $table->timestamps();
            
            $table->foreign('kode_satker')->references('kode')->on('satkers')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('petugas');
    }
}
