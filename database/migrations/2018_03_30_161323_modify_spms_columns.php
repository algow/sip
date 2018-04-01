<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySpmsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spms', function (Blueprint $table) {
            $table->string('kode', 48)->change();
            $table->date('tanggal_spm')->nullable()->change();
            $table->boolean('tanda_terima')->default(0)->change();
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
            $table->string('kode', 10)->change();
            $table->date('tanggal_spm')->change();
            $table->boolean('tanda_terima')->default(0)->change();
        });
    }
}
