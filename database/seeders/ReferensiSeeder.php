<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\Semester;
use App\Models\Sex;
use App\Models\Tuk;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReferensiSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        if (Sex::count() === 0) {
            Sex::insert([
                ['sex' => 'Laki-laki', 'created_at' => $now, 'updated_at' => $now],
                ['sex' => 'Perempuan', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (Jurusan::count() === 0) {
            Jurusan::insert([
                ['jurusan' => 'Teknik Informatika', 'created_at' => $now, 'updated_at' => $now],
                ['jurusan' => 'Teknik Mesin', 'created_at' => $now, 'updated_at' => $now],
                ['jurusan' => 'Teknik Elektro', 'created_at' => $now, 'updated_at' => $now],
                ['jurusan' => 'Akuntansi', 'created_at' => $now, 'updated_at' => $now],
                ['jurusan' => 'Administrasi Bisnis', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (Semester::count() === 0) {
            Semester::insert([
                ['semester' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['semester' => 2, 'created_at' => $now, 'updated_at' => $now],
                ['semester' => 3, 'created_at' => $now, 'updated_at' => $now],
                ['semester' => 4, 'created_at' => $now, 'updated_at' => $now],
                ['semester' => 5, 'created_at' => $now, 'updated_at' => $now],
                ['semester' => 6, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (Tuk::count() === 0) {
            Tuk::insert([
                ['tuk' => 'TUK Utama', 'alamat' => 'Jl. Contoh No. 123', 'jenis_tuk' => 'Mandiri', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        if (Status::count() === 0) {
            Status::insert([
                ['status' => 'Aktif', 'keterangan' => 'Skema aktif', 'created_at' => $now, 'updated_at' => $now],
                ['status' => 'Tidak Aktif', 'keterangan' => 'Skema tidak aktif', 'created_at' => $now, 'updated_at' => $now],
            ]);
        }
    }
}
