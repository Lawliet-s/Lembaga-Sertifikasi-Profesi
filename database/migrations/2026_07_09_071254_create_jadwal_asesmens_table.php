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
        Schema::create('jadwal_asesmens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skema_id');
            $table->unsignedBigInteger('tuk_id');
            $table->date('tanggal');
            $table->string('jam')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('aktif');
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
        Schema::dropIfExists('jadwal_asesmens');
    }
};
