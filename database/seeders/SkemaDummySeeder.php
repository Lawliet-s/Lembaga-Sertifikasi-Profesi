<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skema;
use App\Models\Jurusan;
use App\Models\Tuk;
use App\Models\Asesor;

class SkemaDummySeeder extends Seeder
{
    public function run()
    {
        $jurusanId = Jurusan::first()->id ?? 1;
        $tukId = Tuk::first()->id ?? 1;
        $asesorId = Asesor::first()->id ?? 1;

        $skemas = [
            [
                'kode_skema' => 'SKM-001',
                'skema' => 'Junior Web Developer',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
            ],
            [
                'kode_skema' => 'SKM-002',
                'skema' => 'Network Administrator Muda',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
            ],
            [
                'kode_skema' => 'SKM-003',
                'skema' => 'Digital Marketing Specialist',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
            ],
            [
                'kode_skema' => 'SKM-004',
                'skema' => 'Graphic Designer',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
            ],
            [
                'kode_skema' => 'SKM-005',
                'skema' => 'Data Analyst Junior',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
            ],
        ];

        foreach ($skemas as $data) {
            Skema::firstOrCreate(
                ['kode_skema' => $data['kode_skema']],
                $data
            );
        }
    }
}
