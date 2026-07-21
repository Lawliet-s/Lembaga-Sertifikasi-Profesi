<?php

namespace Database\Seeders;

use App\Models\Asesor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsesorSeeder extends Seeder
{
    public function run()
    {
        $asesorUsers = User::role('asesor')->get();

        foreach ($asesorUsers as $user) {
            Asesor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nama' => $user->name,
                    'email' => $user->email,
                    'no_registrasi' => 'ASR' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                    'status' => 'Aktif',
                ]
            );
        }
    }
}
