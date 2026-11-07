<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tuk', function (Blueprint $table) {
            $table->string('kode', 255)->nullable()->change();
            $table->string('pengelola', 255)->nullable()->change();
            $table->string('tuk', 255)->nullable()->change();
            $table->string('alamat', 255)->nullable()->change();
            $table->string('jenis_tuk', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tuk', function (Blueprint $table) {
            $table->string('kode', 50)->nullable()->change();
            $table->string('pengelola', 50)->nullable()->change();
            $table->string('tuk', 50)->nullable()->change();
            $table->string('alamat', 50)->nullable()->change();
            $table->string('jenis_tuk', 50)->nullable()->change();
        });
    }
};
