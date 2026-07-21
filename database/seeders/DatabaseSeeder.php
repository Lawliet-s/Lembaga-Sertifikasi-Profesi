<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(ReferensiSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AsesorSeeder::class);
        $this->call(VerifikasiSkemaSeeder::class);
    }
}
