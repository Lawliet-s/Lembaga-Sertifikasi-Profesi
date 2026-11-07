<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNomorSertifikatToDataRegistersTable extends Migration
{
    public function up()
    {
        Schema::table('data_registers', function (Blueprint $table) {
            if (!Schema::hasColumn('data_registers', 'nomor_sertifikat')) {
                $table->string('nomor_sertifikat')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('data_registers', function (Blueprint $table) {
            if (Schema::hasColumn('data_registers', 'nomor_sertifikat')) {
                $table->dropColumn('nomor_sertifikat');
            }
        });
    }
}
