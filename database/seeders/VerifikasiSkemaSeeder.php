<?php

namespace Database\Seeders;

use App\Models\VerifikasiSkema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerifikasiSkemaSeeder extends Seeder
{
    public function run()
    {
        $verifikasi = [
            ['name' => 'Belum Diverifikasi'],
            ['name' => 'Terverifikasi'],
            ['name' => 'Dalam Proses'],
            ['name' => 'Ditolak'],
        ];

        foreach ($verifikasi as $item) {
            VerifikasiSkema::firstOrCreate(['name' => $item['name']]);
        }
    }
}
