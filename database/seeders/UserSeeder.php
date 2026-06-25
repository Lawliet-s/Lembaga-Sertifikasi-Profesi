<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'asesi']);
        Role::firstOrCreate(['name' => 'asesor']);

        $admin = User::updateOrCreate(
            ['email' => env('SEEDER_ADMIN_EMAIL', 'admin@admin.com')],
            [
                'name' => 'Admin Role',
                'password' => bcrypt(env('SEEDER_ADMIN_PASSWORD', 'admin123!')),
                'jurusan_id' => 1,
            ]
        );
        $admin->syncRoles(['admin']);

        $user = User::updateOrCreate(
            ['email' => env('SEEDER_ASESIS_EMAIL', 'asesi@asesi.com')],
            [
                'name' => 'Asesi',
                'nik' => '1234567890123456',
                'password' => bcrypt(env('SEEDER_ASESIS_PASSWORD', 'asesi123!')),
                'jurusan_id' => 1,
            ]
        );
        $user->syncRoles(['asesi']);

        $asesor = User::updateOrCreate(
            ['email' => env('SEEDER_ASESOR_EMAIL', 'asesor@asesor.com')],
            [
                'name' => 'Asesor',
                'password' => bcrypt(env('SEEDER_ASESOR_PASSWORD', 'asesor123!')),
                'role' => 'asesor',
                'jurusan_id' => 1,
            ]
        );
        $asesor->syncRoles(['asesor']);
    }
}
