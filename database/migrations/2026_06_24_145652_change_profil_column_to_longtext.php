<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            Schema::table('f_profil', function (Blueprint $table) {
                $table->text('profil')->nullable()->change();
            });
        } else {
            DB::statement('ALTER TABLE f_profil MODIFY profil LONGTEXT NULL');
        }
    }

    public function down()
    {
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'sqlite') {
            Schema::table('f_profil', function (Blueprint $table) {
                $table->text('profil')->nullable()->change();
            });
        } else {
            DB::statement('ALTER TABLE f_profil MODIFY profil TEXT NULL');
        }
    }
};
