<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropKontrak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('kontraks');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('kontraks', function (Blueprint $table) {
            $table->increments('id');
            $table->char('kode', 40);
            $table->string('nama_supplier');
            $table->date('tanggal_spm')->nullable();
            $table->date('tanggal_terima');
            $table->unsignedBigInteger('nilai_kontrak');
            $table->string('keterangan', 300);
            $table->boolean('tanda_terima')->default(0);
            $table->date('diambil_pada')->nullable();
            $table->char('kode_satker');
            $table->timestamps();
            
            $table->foreign('kode_satker')->references('kode')->on('satkers')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
