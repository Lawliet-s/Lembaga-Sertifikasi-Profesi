<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataRegisterIdToPermohonanSertifikasisTable extends Migration
{
    public function up()
    {
        Schema::table('permohonan_sertifikasis', function (Blueprint $table) {
            $table->bigInteger('data_register_id')->nullable()->after('skema_id');
            $table->index('data_register_id');
        });
    }

    public function down()
    {
        Schema::table('permohonan_sertifikasis', function (Blueprint $table) {
            $table->dropIndex(['data_register_id']);
            $table->dropColumn('data_register_id');
        });
    }
}
