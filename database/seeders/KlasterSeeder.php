<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klaster;

class KlasterSeeder extends Seeder
{
    public function run(): void
    {
        Klaster::create([
            'kode_klaster' => 'K1',
            'nama_klaster' => 'Manajemen',
            'keterangan' => 'Klaster manajemen dan administrasi pelayanan Puskesmas',
        ]);

        Klaster::create([
            'kode_klaster' => 'K2',
            'nama_klaster' => 'Kesehatan Ibu dan Anak',
            'keterangan' => 'Klaster pelayanan kesehatan ibu, bayi, balita, anak dan remaja',
        ]);

        Klaster::create([
            'kode_klaster' => 'K3',
            'nama_klaster' => 'Usia Produktif dan Lansia',
            'keterangan' => 'Klaster pelayanan kesehatan usia produktif dan lanjut usia',
        ]);

        Klaster::create([
            'kode_klaster' => 'K4',
            'nama_klaster' => 'Penanggulangan Penyakit Menular',
            'keterangan' => 'Klaster pencegahan dan penanggulangan penyakit menular',
        ]);

        Klaster::create([
            'kode_klaster' => 'K5',
            'nama_klaster' => 'Lintas Klaster',
            'keterangan' => 'Data dan pelayanan yang mencakup lintas klaster',
        ]);
    }
}