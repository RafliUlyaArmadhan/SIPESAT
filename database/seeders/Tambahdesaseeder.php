<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Desa;

/**
 * Menambahkan desa yang tertinggal saat seeding awal (dibandingkan
 * data resmi Kepmendagri 2025). Aman dijalankan berkali-kali karena
 * pakai firstOrCreate (tidak akan membuat duplikat).
 *
 * Jalankan dengan: php artisan db:seed --class=TambahDesaSeeder
 */
class TambahDesaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            '3520020' => ['BUNGKUK', 'NGUNUT', 'SUNDUL'], // PARANG
            '3520030' => ['TUNGGUR', 'DUKUH', 'PUPUS'], // LEMBEYAN
            '3520040' => ['DUYUNG'], // TAKERAN
            '3520041' => ['SEMEN'], // NGUNTORONADI
            '3520050' => ['NGENTEP', 'NGUNUT', 'TULUNG'], // KAWEDANAN
            '3520061' => ['PENDEM', 'SUMBERDUKUN'], // NGARIBOYO
            '3520070' => ['PLUMPUNG', 'BULUGUNUNG'], // PLAOSAN
            '3520080' => ['TERUNG'], // PANEKAN
            '3520090' => ['BULU', 'TRUNENG'], // SUKOMORO
            '3520100' => ['DUKUH', 'BULUGLEDEG', 'DUWET', 'SETREN'], // BENDO
            '3520110' => ['GULUN', 'NGUJUNG', 'PESU'], // MAOSPATI
            '3520120' => ['PELEM'], // KARANGREJO
            '3520121' => ['JUNGKE'], // KARAS
            '3520130' => ['NGUMPUL'], // BARAT
            '3520131' => ['JERUK'], // KARTOHARJO
        ];

        foreach ($data as $kodeKecamatan => $desaList) {
            $kecamatan = Kecamatan::where('kode_kecamatan', $kodeKecamatan)->first();

            if (!$kecamatan) {
                $this->command->warn("Kecamatan dengan kode {$kodeKecamatan} tidak ditemukan, dilewati.");
                continue;
            }

            foreach ($desaList as $namaDesa) {
                Desa::firstOrCreate([
                    'kecamatan_id' => $kecamatan->id,
                    'nama_desa' => $namaDesa,
                ]);
            }
        }

        $this->command->info('Selesai menambahkan desa yang kurang.');
    }
}