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
        Schema::table('asesor', function (Blueprint $table) {
            $table->string('no_registrasi', 25)->nullable()->unique()->after('nik');
            $table->unsignedInteger('user_id')->nullable()->after('no_registrasi');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('asesor', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['no_registrasi', 'user_id']);
        });
    }
};
