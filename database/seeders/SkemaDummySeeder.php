<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skema;
use App\Models\Jurusan;
use App\Models\Tuk;
use App\Models\Asesor;
use App\Models\Unikom;
use App\Models\Asesmen;

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
                'units' => [
                    [
                        'kode_unikom' => 'JWD.01',
                        'unikom' => 'Menerapkan Prinsip K3LH di Lingkungan Kerja',
                        'elemen' => [
                            ['kriteria' => 'Mengikuti prosedur Keselamatan dan Kesehatan Kerja (K3)', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Mengidentifikasi potensi bahaya di tempat kerja', 'asesmen' => 'Ya'],
                        ]
                    ],
                    [
                        'kode_unikom' => 'JWD.02',
                        'unikom' => 'Melakukan Pemrograman Berorientasi Objek',
                        'elemen' => [
                            ['kriteria' => 'Menerapkan konsep class dan object', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Menggunakan pewarisan (inheritance) dan polimorfisme', 'asesmen' => 'Ya'],
                        ]
                    ],
                    [
                        'kode_unikom' => 'JWD.03',
                        'unikom' => 'Mengembangkan Aplikasi Web Menggunakan Framework Laravel',
                        'elemen' => [
                            ['kriteria' => 'Mengonfigurasi routing dan controller pada Laravel', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Menggunakan Eloquent ORM untuk manajemen database', 'asesmen' => 'Ya'],
                        ]
                    ],
                ]
            ],
            [
                'kode_skema' => 'SKM-002',
                'skema' => 'Network Administrator Muda',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
                'units' => [
                    [
                        'kode_unikom' => 'NET.01',
                        'unikom' => 'Merancang Topologi Jaringan Lokal (LAN)',
                        'elemen' => [
                            ['kriteria' => 'Menentukan spesifikasi perangkat jaringan', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Membuat gambar topologi jaringan fisik dan logis', 'asesmen' => 'Ya'],
                        ]
                    ],
                    [
                        'kode_unikom' => 'NET.02',
                        'unikom' => 'Mengkonfigurasi Routing pada Perangkat Jaringan',
                        'elemen' => [
                            ['kriteria' => 'Mengonfigurasi static routing', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Mengonfigurasi dynamic routing (OSPF/EIGRP)', 'asesmen' => 'Ya'],
                        ]
                    ],
                ]
            ],
            [
                'kode_skema' => 'SKM-003',
                'skema' => 'Digital Marketing Specialist',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
                'units' => [
                    [
                        'kode_unikom' => 'DM.01',
                        'unikom' => 'Menyusun Strategi Pemasaran Digital',
                        'elemen' => [
                            ['kriteria' => 'Melakukan analisis target audiens dan kompetitor', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Menentukan platform digital marketing yang sesuai', 'asesmen' => 'Ya'],
                        ]
                    ],
                    [
                        'kode_unikom' => 'DM.02',
                        'unikom' => 'Mengelola Kampanye Iklan Berbayar (SEM/Social Ads)',
                        'elemen' => [
                            ['kriteria' => 'Menyusun copywriting dan materi visual iklan', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Melakukan monitoring dan optimasi budget iklan', 'asesmen' => 'Ya'],
                        ]
                    ],
                ]
            ],
            [
                'kode_skema' => 'SKM-004',
                'skema' => 'Graphic Designer',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
                'units' => [
                    [
                        'kode_unikom' => 'GD.01',
                        'unikom' => 'Mengoperasikan Perangkat Lunak Desain Grafis (Adobe/Corel)',
                        'elemen' => [
                            ['kriteria' => 'Menggunakan tools vector dan raster', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Mengatur color profile (RGB/CMYK)', 'asesmen' => 'Ya'],
                        ]
                    ],
                    [
                        'kode_unikom' => 'GD.02',
                        'unikom' => 'Menerapkan Prinsip Desain Visual dan Komunikasi',
                        'elemen' => [
                            ['kriteria' => 'Mengatur tata letak (layout) dan tipografi', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Membuat karya desain sesuai brief klien', 'asesmen' => 'Ya'],
                        ]
                    ],
                ]
            ],
            [
                'kode_skema' => 'SKM-005',
                'skema' => 'Data Analyst Junior',
                'status_id' => 1,
                'jurusan_id' => $jurusanId,
                'tuk_id' => $tukId,
                'asesor_id' => $asesorId,
                'units' => [
                    [
                        'kode_unikom' => 'DA.01',
                        'unikom' => 'Melakukan Pengumpulan dan Pembersihan Data (Data Cleansing)',
                        'elemen' => [
                            ['kriteria' => 'Mengidentifikasi missing value dan duplikasi data', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Melakukan transformasi format data', 'asesmen' => 'Ya'],
                        ]
                    ],
                    [
                        'kode_unikom' => 'DA.02',
                        'unikom' => 'Membuat Visualisasi Data dan Dashboard Interaktif',
                        'elemen' => [
                            ['kriteria' => 'Memilih jenis chart yang sesuai dengan karakteristik data', 'asesmen' => 'Ya'],
                            ['kriteria' => 'Menyajikan laporan analitik dalam bentuk dashboard', 'asesmen' => 'Ya'],
                        ]
                    ],
                ]
            ],
        ];

        foreach ($skemas as $data) {
            $units = $data['units'] ?? [];
            unset($data['units']);

            $skema = Skema::firstOrCreate(
                ['kode_skema' => $data['kode_skema']],
                $data
            );

            foreach ($units as $unitData) {
                $elemenList = $unitData['elemen'] ?? [];
                unset($unitData['elemen']);

                $unikom = Unikom::firstOrCreate(
                    [
                        'skema_id' => $skema->id,
                        'kode_unikom' => $unitData['kode_unikom']
                    ],
                    [
                        'unikom' => $unitData['unikom']
                    ]
                );

                foreach ($elemenList as $elemen) {
                    Asesmen::firstOrCreate(
                        [
                            'unikom_id' => $unikom->id,
                            'kriteria' => $elemen['kriteria']
                        ],
                        [
                            'asesmen' => $elemen['asesmen']
                        ]
                    );
                }
            }
        }
    }
}
