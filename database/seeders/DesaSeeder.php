<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = base_path('dataset-wilayah-indonesia/villages.csv');

        $handle = fopen($file, 'r');

        while (($row = fgetcsv($handle)) !== false) {

            // Ambil hanya desa/kelurahan Kabupaten Magetan
            if (!str_starts_with($row[0], '3520')) {
                continue;
            }

            $kecamatan = DB::table('kecamatans')
                ->where('kode_kecamatan', $row[1])
                ->first();

            if (!$kecamatan) {
                continue;
            }

            DB::table('desas')->insert([
                'kecamatan_id' => $kecamatan->id,
                'kode_desa' => $row[0],
                'nama_desa' => $row[2],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($handle);
    }
}
