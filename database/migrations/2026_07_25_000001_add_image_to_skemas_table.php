<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('skemas', function (Blueprint $table) {
            $table->string('image')->nullable()->after('status_id');
        });
    }

    public function down()
    {
        Schema::table('skemas', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
