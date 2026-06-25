<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixStatusData extends Command
{
    protected $signature = 'fix:status-data';
    protected $description = 'Convert old HTML status values to plain text';

    private array $statusMaps = [
        'data_registers' => [
            'status' => [
                "<h4 style='color: green'>Menunggu Validasi...</h4>" => 'Menunggu Validasi',
                "<h4 style='color: rgb(34, 123, 138)'>Pendaftaran Divalidasi</h4>" => 'Pendaftaran Divalidasi',
                "<h4 style='color: rgb(0, 0, 0)'>Sertifikasi Selesai</h4>" => 'Sertifikasi Selesai',
                "<h4 style='color: rgb(141, 7, 7)'>Pendaftaran Ditolak</h4>" => 'Pendaftaran Ditolak',
                "<h4 style='color: rgb(163, 129, 8)'>Lengkapi Data Anda</h4>" => 'Lengkapi Data Anda',
                "<h4 style='color: #000'>Pendaftaran Sementara Diblokir</h4>" => 'Pendaftaran Sementara Diblokir',
            ],
        ],
        'xnxxes' => [
            'status' => [
                "<label class='badge badge-outline-success badge-pill'>&#10004; Kompeten</label>" => 'kompeten',
                "<label class='badge badge-outline-danger badge-pill'>&#10008; Tidak Kompeten</label>" => 'tidak_kompeten',
            ],
            'koreksi' => [
                "<label class='badge badge-outline-warning badge-pill'>Belum Dikoreksi</label>" => 'Belum Dikoreksi',
            ],
        ],
        'upload_files' => [
            'status' => [
                "<label class='badge badge-outline-warning badge-pill'>Belum Dikoreksi</label>" => 'Belum Dikoreksi',
            ],
        ],
    ];

    public function handle()
    {
        $totalUpdated = [];

        foreach ($this->statusMaps as $table => $columns) {
            $totalUpdated[$table] = 0;

            foreach ($columns as $column => $maps) {
                foreach ($maps as $html => $plain) {
                    $affected = DB::table($table)
                        ->where($column, 'LIKE', '%' . $html . '%')
                        ->update([$column => $plain]);

                    if ($affected > 0) {
                        $this->line("  {$table}.{$column}: {$affected} row(s) fixed for \"{$plain}\"");
                    }

                    $totalUpdated[$table] += $affected;
                }
            }
        }

        $this->info('Done.');
        $this->table(
            ['Table', 'Records Updated'],
            collect($totalUpdated)->map(fn($count, $table) => [$table, $count])->values()->toArray()
        );

        return 0;
    }
}
