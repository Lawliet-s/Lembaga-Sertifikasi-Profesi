<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLogo2ToSiteSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('logo2')->nullable()->after('logo');
            $table->string('logo3')->nullable()->after('logo2');
            $table->string('logo4')->nullable()->after('logo3');
        });
    }

    public function down()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['logo2', 'logo3', 'logo4']);
        });
    }
}
