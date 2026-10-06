<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Desa;

/**
 * Mengisi kolom kode_desa (kode wilayah resmi Kepmendagri 2025) pada
 * tabel desas yang sudah ada. Jalankan SETELAH migration yang menambah
 * kolom kode_desa (2026_xx_xx_xxxxxx_add_kode_desa_to_desas_table.php).
 *
 * Aman dijalankan berkali-kali: hanya meng-update baris yang cocok
 * berdasarkan kecamatan + nama_desa, tidak membuat data baru.
 *
 * Jalankan dengan: php artisan db:seed --class=IsiKodeDesaSeeder
 */
class IsiKodeDesaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'PONCOL' => [
                'GONGGANG' => '35.20.01.2002',
                'PONCOL' => '35.20.01.2001',
                'CILENG' => '35.20.01.2007',
                'SOMBO' => '35.20.01.2008',
                'PLANGKRONGAN' => '35.20.01.2006',
                'ALASTUWO' => '35.20.01.1005',
                'JANGGAN' => '35.20.01.2003',
                'GENILANGIT' => '35.20.01.2004',
            ],
            'PARANG' => [
                'SAYUTAN' => '35.20.02.2001',
                'NGLOPANG' => '35.20.02.2002',
                'MATEGAL' => '35.20.02.2003',
                'TROSONO' => '35.20.02.2005',
                'NGAGLIK' => '35.20.02.2007',
                'PARANG' => '35.20.02.1008',
                'TAMANARUM' => '35.20.02.2009',
                'PRAGAK' => '35.20.02.2010',
                'KRAJAN' => '35.20.02.2013',
                'JOKETRO' => '35.20.02.2012',
                'BUNGKUK' => '35.20.02.2004',
                'NGUNUT' => '35.20.02.2006',
                'SUNDUL' => '35.20.02.2011',
            ],
            'LEMBEYAN' => [
                'KEDIREN' => '35.20.03.2001',
                'LEMBEYAN KULON' => '35.20.03.1002',
                'LEMBEYAN WETAN' => '35.20.03.2003',
                'KEDUNGPANJI' => '35.20.03.2006',
                'NGURI' => '35.20.03.2007',
                'TAPEN' => '35.20.03.2009',
                'KROWE' => '35.20.03.2010',
                'TUNGGUR' => '35.20.03.2004',
                'DUKUH' => '35.20.03.2005',
                'PUPUS' => '35.20.03.2008',
            ],
            'TAKERAN' => [
                'KIRINGAN' => '35.20.04.2009',
                'TAWANGREJO' => '35.20.04.2011',
                'SAWOJAJAR' => '35.20.04.2012',
                'TAKERAN' => '35.20.04.1013',
                'KUWONHARJO' => '35.20.04.2014',
                'KEPUHREJO' => '35.20.04.2015',
                'KERIK' => '35.20.04.2016',
                'WADUK' => '35.20.04.2017',
                'JOMBLANG' => '35.20.04.2018',
                'KERANG' => '35.20.04.2019',
                'MADIGONDO' => '35.20.04.2020',
                'DUYUNG' => '35.20.04.2010',
            ],
            'NGUNTORONADI' => [
                'SUKOWIDI' => '35.20.17.2001',
                'GORANG GARENG' => '35.20.17.2003',
                'PETUNGREJO' => '35.20.17.2004',
                'NGUNTORONADI' => '35.20.17.2005',
                'DRIYOREJO' => '35.20.17.2009',
                'SIMBATAN' => '35.20.17.2006',
                'PURWOREJO' => '35.20.17.2007',
                'KENONGOMULYO' => '35.20.17.2008',
                'SEMEN' => '35.20.17.2002',
            ],
            'KAWEDANAN' => [
                'GIRIPURNO' => '35.20.05.2002',
                'BALEREJO' => '35.20.05.2004',
                'GARON' => '35.20.05.2005',
                'TLADAN' => '35.20.05.2006',
                'POJOK' => '35.20.05.2007',
                'KAWEDANAN' => '35.20.05.1010',
                'SAMPUNG' => '35.20.05.1012',
                'MANGUNREJO' => '35.20.05.2001',
                'SELOREJO' => '35.20.05.2015',
                'JAMBANGAN' => '35.20.05.2014',
                'BOGEM' => '35.20.05.2013',
                'REJOSARI' => '35.20.05.1011',
                'MOJOREJO' => '35.20.05.2020',
                'GENENGAN' => '35.20.05.2019',
                'KARANGREJO' => '35.20.05.2018',
                'NGADIREJO' => '35.20.05.2017',
                'SUGIHREJO' => '35.20.05.2016',
                'NGENTEP' => '35.20.05.2003',
                'NGUNUT' => '35.20.05.2008',
                'TULUNG' => '35.20.05.2009',
            ],
            'MAGETAN' => [
                'RINGINAGUNG' => '35.20.06.2005',
                'CANDIREJO' => '35.20.06.2009',
                'SELOSARI' => '35.20.06.1010',
                'MAGETAN' => '35.20.06.1004',
                'BULUKERTO' => '35.20.06.1003',
                'MANGKUJAYAN' => '35.20.06.1002',
                'TAMBAKREJO' => '35.20.06.2001',
                'TAMBRAN' => '35.20.06.1015',
                'KEBONAGUNG' => '35.20.06.1014',
                'KEPOLOREJO' => '35.20.06.1012',
                'TAWANGANOM' => '35.20.06.1011',
                'SUKOWINANGUN' => '35.20.06.1013',
                'BARON' => '35.20.06.2016',
                'PURWOSARI' => '35.20.06.2017',
            ],
            'NGARIBOYO' => [
                'SELOTINATAH' => '35.20.16.2001',
                'BANYUDONO' => '35.20.16.2010',
                'BANJARPANJANG' => '35.20.16.2011',
                'BANJAREJO' => '35.20.16.2012',
                'MOJOPURNO' => '35.20.16.2009',
                'BALEGONDO' => '35.20.16.2007',
                'NGARIBOYO' => '35.20.16.2008',
                'BALEASRI' => '35.20.16.2006',
                'SELOPANGGUNG' => '35.20.16.2004',
                'BANGSRI' => '35.20.16.2003',
                'PENDEM' => '35.20.16.2002',
                'SUMBERDUKUN' => '35.20.16.2005',
            ],
            'PLAOSAN' => [
                'NGANCAR' => '35.20.07.2001',
                'PUNTUKDORO' => '35.20.07.2003',
                'BOGOARUM' => '35.20.07.2005',
                'RANDUGEDE' => '35.20.07.2006',
                'SUMBERAGUNG' => '35.20.07.2007',
                'NITIKAN' => '35.20.07.2008',
                'SIDOMUKTI' => '35.20.07.2009',
                'BULUHARJO' => '35.20.07.2010',
                'PLAOSAN' => '35.20.07.1011',
                'DADI' => '35.20.07.2012',
                'SARANGAN' => '35.20.07.1013',
                'PACALAN' => '35.20.07.2014',
                'SENDANGAGUNG' => '35.20.07.2015',
                'PLUMPUNG' => '35.20.07.2002',
                'BULUGUNUNG' => '35.20.07.2004',
            ],
            'SIDOREJO' => [
                'GETASANYAR' => '35.20.18.2006',
                'SIDOREJO' => '35.20.18.2005',
                'DURENAN' => '35.20.18.2004',
                'SAMBIROBYONG' => '35.20.18.2001',
                'CAMPURSARI' => '35.20.18.2002',
                'KALANG' => '35.20.18.2003',
                'WIDOROKANDANG' => '35.20.18.2010',
                'SIDOKERTO' => '35.20.18.2009',
                'SUMBERSAWIT' => '35.20.18.2008',
                'SIDOMULYO' => '35.20.18.2007',
            ],
            'PANEKAN' => [
                'CEPOKO' => '35.20.08.2005',
                'MILANGASRI' => '35.20.08.2006',
                'WATES' => '35.20.08.2007',
                'PANEKAN' => '35.20.08.1009',
                'MANJUNG' => '35.20.08.2012',
                'TANJUNGSARI' => '35.20.08.2010',
                'SUMBERDODOL' => '35.20.08.2011',
                'TAPAK' => '35.20.08.2013',
                'SUKOWIDI' => '35.20.08.2014',
                'BEDAGUNG' => '35.20.08.2015',
                'NGILIRAN' => '35.20.08.2016',
                'JABUNG' => '35.20.08.2017',
                'REJOMULYO' => '35.20.08.2018',
                'TURI' => '35.20.08.2019',
                'SIDOWAYAH' => '35.20.08.2008',
                'BANJAREJO' => '35.20.08.2020',
                'TERUNG' => '35.20.08.2004',
            ],
            'SUKOMORO' => [
                'KALANGKETI' => '35.20.09.2001',
                'TAMANAN' => '35.20.09.2002',
                'TAMBAKMAS' => '35.20.09.2003',
                'BANDAR' => '35.20.09.2004',
                'BIBIS' => '35.20.09.2005',
                'SUKOMORO' => '35.20.09.2006',
                'POJOKSARI' => '35.20.09.2008',
                'TINAP' => '35.20.09.1009',
                'KEMBANGAN' => '35.20.09.2011',
                'KEDUNGGUWO' => '35.20.09.2010',
                'KENTANGAN' => '35.20.09.2012',
                'BOGEM' => '35.20.09.2013',
                'BULU' => '35.20.09.2007',
                'TRUNENG' => '35.20.09.2014',
            ],
            'BENDO' => [
                'BELOTAN' => '35.20.10.2002',
                'PINGKUK' => '35.20.10.2003',
                'TANJUNG' => '35.20.10.2004',
                'TEGALARUM' => '35.20.10.2005',
                'BULAK' => '35.20.10.2006',
                'SOCO' => '35.20.10.2008',
                'CARIKAN' => '35.20.10.2011',
                'BENDO' => '35.20.10.1012',
                'KLECO' => '35.20.10.2016',
                'KLEDOKAN' => '35.20.10.2010',
                'LEMAHBANG' => '35.20.10.2009',
                'KINANDANG' => '35.20.10.2007',
                'DUKUH' => '35.20.10.2001',
                'BULUGLEDEG' => '35.20.10.2013',
                'DUWET' => '35.20.10.2014',
                'SETREN' => '35.20.10.2015',
            ],
            'MAOSPATI' => [
                'SUGIHWARAS' => '35.20.11.2001',
                'TANJUNGSEPREH' => '35.20.11.2002',
                'MALANG' => '35.20.11.2004',
                'MAOSPATI' => '35.20.11.1005',
                'KLAGEN GAMBIRAN' => '35.20.11.2006',
                'PANDEYAN' => '35.20.11.2007',
                'SURATMAJAN' => '35.20.11.2008',
                'RONOWIJAYAN' => '35.20.11.2009',
                'SUMBEREJO' => '35.20.11.2011',
                'KRATON' => '35.20.11.1013',
                'MRANGGEN' => '35.20.11.1014',
                'SEMPOL' => '35.20.11.2015',
                'GULUN' => '35.20.11.2003',
                'NGUJUNG' => '35.20.11.2010',
                'PESU' => '35.20.11.2012',
            ],
            'KARANGREJO' => [
                'MANTREN' => '35.20.13.2002',
                'GONDANG' => '35.20.13.2003',
                'SAMBIREMBE' => '35.20.13.2004',
                'PATIHAN' => '35.20.13.2005',
                'KARANGREJO' => '35.20.13.1001',
                'MANISREJO' => '35.20.13.1006',
                'GEBYOG' => '35.20.13.2009',
                'PRAMPELAN' => '35.20.13.2011',
                'GRABAHAN' => '35.20.13.2012',
                'KAUMAN' => '35.20.13.2013',
                'MARON' => '35.20.13.2010',
                'BALUK' => '35.20.13.2008',
                'PELEM' => '35.20.13.2007',
            ],
            'KARAS' => [
                'BOTOK' => '35.20.14.2010',
                'GINUK' => '35.20.14.2011',
                'TAJI' => '35.20.14.2004',
                'TEMBORO' => '35.20.14.2007',
                'TEMENGGUNGAN' => '35.20.14.2008',
                'GEPLAK' => '35.20.14.2009',
                'KARAS' => '35.20.14.2001',
                'KUWON' => '35.20.14.2005',
                'SOBONTORO' => '35.20.14.2002',
                'SUMURSONGO' => '35.20.14.2003',
                'JUNGKE' => '35.20.14.2006',
            ],
            'BARAT' => [
                'BANJAREJO' => '35.20.12.2002',
                'PURWODADI' => '35.20.12.2004',
                'KARANGSONO' => '35.20.12.2003',
                'BOGOREJO' => '35.20.12.2001',
                'TEBON' => '35.20.12.1006',
                'MANJUNG' => '35.20.12.2007',
                'PANGGUNG' => '35.20.12.2009',
                'KLAGEN' => '35.20.12.2014',
                'BANGUNASRI' => '35.20.12.2013',
                'BLARAN' => '35.20.12.2010',
                'MANGGE' => '35.20.12.1005',
                'JONGGRANG' => '35.20.12.2011',
                'REJOMULYO' => '35.20.12.2012',
                'NGUMPUL' => '35.20.12.2008',
            ],
            'KARTOHARJO' => [
                'KLURAHAN' => '35.20.15.2003',
                'PENCOL' => '35.20.15.2004',
                'SUKOWIDI' => '35.20.15.2005',
                'KARTOHARJO' => '35.20.15.2001',
                'NGELANG' => '35.20.15.2006',
                'JAJAR' => '35.20.15.2007',
                'GUNUNGAN' => '35.20.15.2008',
                'KARANGMOJO' => '35.20.15.2012',
                'MRAHU' => '35.20.15.2002',
                'BAYEM TAMAN' => '35.20.15.2011',
                'BAYEM WETAN' => '35.20.15.2010',
                'JERUK' => '35.20.15.2009',
            ],
        ];

        $updated = 0;
        $tidakDitemukan = [];

        foreach ($data as $namaKecamatan => $desaList) {
            $kecamatan = Kecamatan::where('nama_kecamatan', $namaKecamatan)->first();

            if (!$kecamatan) {
                $this->command->warn("Kecamatan {$namaKecamatan} tidak ditemukan, dilewati.");
                continue;
            }

            foreach ($desaList as $namaDesa => $kodeDesa) {
                $affected = Desa::where('kecamatan_id', $kecamatan->id)
                    ->where('nama_desa', $namaDesa)
                    ->update(['kode_desa' => $kodeDesa]);

                if ($affected > 0) {
                    $updated += $affected;
                } else {
                    $tidakDitemukan[] = "{$namaKecamatan} - {$namaDesa}";
                }
            }
        }

        $this->command->info("Selesai. {$updated} desa berhasil diisi kode_desa-nya.");

        if (!empty($tidakDitemukan)) {
            $this->command->warn('Tidak ditemukan (periksa ejaan nama_desa di database): ' . implode(', ', $tidakDitemukan));
        }
    }
}