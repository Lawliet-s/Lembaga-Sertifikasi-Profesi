<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CheckImages extends Command
{
    protected $signature = 'images:check {--fix : Kosongkan field image jika file fisik tidak ada}';
    protected $description = 'Periksa dan laporkan gambar di database yang filenya sudah hilang atau rusak';

    public function handle()
    {
        $shouldFix = $this->option('fix');
        $tables = [
            'users' => 'image',
            'skemas' => 'image',
            'tuks' => 'image',
            'site_settings' => 'logo',
        ];

        // Cek juga about_image, background_image di site_settings jika ada
        $totalMissing = 0;

        foreach ($tables as $table => $column) {
            if (!\Schema::hasTable($table) || !\Schema::hasColumn($table, $column)) {
                continue;
            }

            $records = DB::table($table)->whereNotNull($column)->where($column, '!=', '')->get();
            foreach ($records as $record) {
                $path = public_path($record->$column);
                if (!File::exists($path) || filesize($path) == 0) {
                    $totalMissing++;
                    $this->line("Missing in <fg=yellow>{$table}.{$column}</> (ID: {$record->id}): <fg=red>{$record->$column}</>");
                    
                    if ($shouldFix) {
                        DB::table($table)->where('id', $record->id)->update([$column => null]);
                        $this->info(" -> Fixed: set to null");
                    }
                }
            }
        }

        // Cek kolom tambahan di site_settings
        if (\Schema::hasTable('site_settings')) {
            foreach (['favicon', 'about_image', 'header_image', 'background_image'] as $col) {
                if (\Schema::hasColumn('site_settings', $col)) {
                    $records = DB::table('site_settings')->whereNotNull($col)->where($col, '!=', '')->get();
                    foreach ($records as $record) {
                        $path = public_path($record->$col);
                        if (!File::exists($path) || filesize($path) == 0) {
                            $totalMissing++;
                            $this->line("Missing in <fg=yellow>site_settings.{$col}</> (ID: {$record->id}): <fg=red>{$record->$col}</>");
                            if ($shouldFix) {
                                DB::table('site_settings')->where('id', $record->id)->update([$col => null]);
                                $this->info(" -> Fixed: set to null");
                            }
                        }
                    }
                }
            }
        }

        $this->info("Total missing/broken images found: {$totalMissing}");
        if (!$shouldFix && $totalMissing > 0) {
            $this->comment("Jalankan 'php artisan images:check --fix' untuk membersihkan record yang rusak.");
        }

        return Command::SUCCESS;
    }
}
