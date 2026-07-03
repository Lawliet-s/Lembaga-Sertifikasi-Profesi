<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceProdiWithJurusanInSkemasTable extends Migration
{
    public function up()
    {
        Schema::table('skemas', function (Blueprint $table) {
            $table->dropColumn('prodi_id');
        });

        Schema::table('skemas', function (Blueprint $table) {
            $table->unsignedInteger('jurusan_id')->after('skema');
        });

        Schema::dropIfExists('prodi');
    }

    public function down()
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('prodi');
            $table->timestamp('updated_at', 6)->useCurrent();
            $table->timestamp('created_at', 6)->useCurrent();
        });

        Schema::table('skemas', function (Blueprint $table) {
            $table->dropColumn('jurusan_id');
        });

        Schema::table('skemas', function (Blueprint $table) {
            $table->unsignedInteger('prodi_id')->after('skema');
        });
    }
}
