<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkeyPengambilOnSpms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spms', function (Blueprint $table) {
            $table->foreign('pengambil')->references('barcode')->on('petugas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spms', function (Blueprint $table) {
            $table->dropForeign('spms_pengambil_foreign');
        });
    }
}
