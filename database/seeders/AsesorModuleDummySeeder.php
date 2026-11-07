<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Asesor;
use App\Models\Data_register;
use App\Models\Skema;
use App\Models\Tuk;
use App\Models\Penilaian;
use App\Models\Observasi;

class AsesorModuleDummySeeder extends Seeder
{
    public function run()
    {
        // 1. Pastikan ada user asesor
        $asesorUser = User::firstOrCreate(
            ['email' => 'asesor.utama@lsp.com'],
            [
                'name' => 'Budi Santoso, M.Kom., AIFO',
                'password' => bcrypt('password'),
                'jurusan_id' => 1,
            ]
        );
        $asesorUser->syncRoles(['asesor']);

        $asesor = Asesor::firstOrCreate(
            ['user_id' => $asesorUser->id],
            [
                'no_registrasi' => 'ASR-998877',
                'nama' => $asesorUser->name,
                'email' => $asesorUser->email,
                'status' => 'Aktif',
                'alamat' => 'Jl. Sertifikasi Profesional No. 45, Jakarta',
                'no_hp' => '081234567890',
            ]
        );

        // 2. Pastikan ada TUK dan Skema
        $tuk = Tuk::first();
        $skema = Skema::first();

        if (!$tuk || !$skema) {
            return;
        }

        // 3. Buat asesi dummy yang ditugaskan ke asesor ini
        $dummyAsesis = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi.pratama@gmail.com',
                'nik' => '3171012345670001',
                'status' => 'Pendaftaran Divalidasi',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@gmail.com',
                'nik' => '3171012345670002',
                'status' => 'Kompeten',
            ],
            [
                'name' => 'Reza Pahlevi',
                'email' => 'reza.pahlevi@gmail.com',
                'nik' => '3171012345670003',
                'status' => 'Belum Kompeten',
            ],
        ];

        foreach ($dummyAsesis as $dataAsesi) {
            $asesiUser = User::firstOrCreate(
                ['email' => $dataAsesi['email']],
                [
                    'name' => $dataAsesi['name'],
                    'password' => bcrypt('password'),
                    'nik' => $dataAsesi['nik'],
                    'jurusan_id' => 1,
                ]
            );
            $asesiUser->syncRoles(['asesi']);

            $register = Data_register::firstOrCreate(
                [
                    'user_id' => $asesiUser->id,
                    'skema_id' => $skema->id,
                ],
                [
                    'id' => rand(10000, 99999),
                    'kode' => 'REG-' . strtoupper(substr(md5($asesiUser->id), 0, 6)),
                    'nik' => $dataAsesi['nik'],
                    'skema_name' => $skema->skema,
                    'kode_skema' => $skema->kode_skema,
                    'id_skema' => $skema->id,
                    'user_name' => $asesiUser->name,
                    'surel' => $dataAsesi['email'],
                    'tuk_id' => $tuk->id,
                    'asesor_id' => $asesor->id,
                    'status' => $dataAsesi['status'],
                    'date' => now()->addDays(rand(1, 5))->format('Y-m-d'),
                    'time' => '09:00',
                    'alamat' => 'Jl. Contoh Alamat Asesi No. ' . rand(1, 100),
                    'no_hp' => '08987654321' . rand(0, 9),
                    'institusi' => 'Universitas / SMK Teknologi',
                    'jabatan' => 'Peserta Uji',
                    'rekomendasi_data' => [
                        'keputusan' => $dataAsesi['status'] === 'Kompeten' ? 'Direkomendasikan Sertifikasi' : 'Perlu Perbaikan',
                        'catatan' => 'Hasil asesmen komprehensif telah diverifikasi.',
                    ],
                ]
            );

            // Tambahkan contoh penilaian jika belum ada
            foreach ($skema->unikoms as $unikom) {
                Penilaian::firstOrCreate(
                    [
                        'data_register_id' => $register->id,
                        'unikom_id' => $unikom->id,
                    ],
                    [
                        'nilai' => $dataAsesi['status'] === 'Belum Kompeten' ? 'belum' : 'kompeten',
                    ]
                );
            }

            // Tambahkan contoh observasi jika belum ada
            Observasi::firstOrCreate(
                ['data_register_id' => $register->id],
                [
                    'aktivitas' => [
                        ['nama' => 'Wawancara Teknis Unit Kompetensi', 'hasil' => 'Baik'],
                        ['nama' => 'Demonstrasi Praktik Langsung', 'hasil' => 'Baik'],
                    ],
                    'catatan' => 'Asesi mampu menyelesaikan tugas praktek dengan standar yang ditentukan.',
                ]
            );
        }
    }
}
