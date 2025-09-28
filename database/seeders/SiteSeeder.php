<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Site; // <-- Jangan lupa tambahkan ini
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini juga

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel dulu biar nggak ada data duplikat
        DB::table('sites')->truncate();

        $sites = [
            [
                'name' => 'PT. Global Tekno Mediakom (99,9 FM site Purnawarman)',
                'ip_address' => '10.10.2.89',
                'latitude' => -6.8895193,
                'longitude' => 107.6135585,
            ],
            [
                'name' => 'SMK Lugina',
                'ip_address' => '172.16.158.29',
                'latitude' => -6.9581723,
                'longitude' => 107.7665290,
            ],
            [
                'name' => 'SMK Bintang Madani',
                'ip_address' => '172.16.158.30',
                'latitude' => -6.9128985,
                'longitude' => 107.6815820,
            ],
            [
                'name' => 'WINFREE - Masjid Almurabbi',
                'ip_address' => '172.16.202.139',
                'latitude' => -6.8793181,
                'longitude' => 107.5834142,
            ],
            [
                'name' => 'Ilos Hotel',
                'ip_address' => '172.16.158.44',
                'latitude' => -6.8906393,
                'longitude' => 107.5845459,
            ],
            [
                'name' => 'SD Arvardia Islamic',
                'ip_address' => '172.16.158.45',
                'latitude' => -6.9262398,
                'longitude' => 107.6827759,
            ],
            [
                'name' => 'RW 03 Sukadana',
                'ip_address' => '10.12.0.40',
                'latitude' => 0, // Koordinat tidak ada, diisi 0 dulu
                'longitude' => 0,
            ],
            [
                'name' => 'RW 08 Sindangkasih',
                'ip_address' => '10.12.0.39',
                'latitude' => 0, // Koordinat tidak ada, diisi 0 dulu
                'longitude' => 0,
            ],
            [
                'name' => 'RW09-Kel.Antapaniwetan',
                'ip_address' => '172.16.203.193',
                'latitude' => -6.90797,
                'longitude' => 107.66368,
            ],
            [
                'name' => 'RW01-KEL SUKARAJA',
                'ip_address' => '172.16.201.19',
                'latitude' => -6.92535,
                'longitude' => 107.7205,
            ],
        ];

        // Masukkan semua data ke database
        foreach ($sites as $site) {
            Site::create($site);
        }
    }
}
