<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('dataset-wilayah-indonesia/districts.csv');

        $handle = fopen($file, 'r');

        while (($row = fgetcsv($handle)) !== false) {

            // Ambil hanya kecamatan Kabupaten Magetan
            if ($row[1] !== '3520') {
                continue;
            }

            DB::table('kecamatans')->insert([
                'kode_kecamatan' => $row[0],
                'nama_kecamatan' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($handle);
    }
}