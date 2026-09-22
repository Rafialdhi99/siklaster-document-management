<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisDokumen;

class JenisDokumenSeeder extends Seeder
{
    public function run(): void
    {
        $jenisDokumen = [
            [
                'kode_jenis' => 'JD-01',
                'nama_jenis' => 'Laporan Bulanan',
                'keterangan' => 'Laporan kegiatan atau program secara bulanan',
            ],
            [
                'kode_jenis' => 'JD-02',
                'nama_jenis' => 'Laporan Tahunan',
                'keterangan' => 'Laporan kegiatan atau program secara tahunan',
            ],
            [
                'kode_jenis' => 'JD-03',
                'nama_jenis' => 'Rekapitulasi Data',
                'keterangan' => 'Rekapitulasi data kegiatan atau pelayanan',
            ],
            [
                'kode_jenis' => 'JD-04',
                'nama_jenis' => 'SOP',
                'keterangan' => 'Standar Operasional Prosedur',
            ],
            [
                'kode_jenis' => 'JD-05',
                'nama_jenis' => 'SK',
                'keterangan' => 'Surat Keputusan',
            ],
            [
                'kode_jenis' => 'JD-06',
                'nama_jenis' => 'Surat',
                'keterangan' => 'Surat kedinasan atau surat administrasi',
            ],
            [
                'kode_jenis' => 'JD-07',
                'nama_jenis' => 'Pedoman',
                'keterangan' => 'Pedoman atau petunjuk pelaksanaan kegiatan',
            ],
            [
                'kode_jenis' => 'JD-08',
                'nama_jenis' => 'Formulir',
                'keterangan' => 'Formulir yang digunakan dalam kegiatan Puskesmas',
            ],
            [
                'kode_jenis' => 'JD-09',
                'nama_jenis' => 'Dokumentasi',
                'keterangan' => 'Dokumentasi kegiatan dalam bentuk file',
            ],
            [
                'kode_jenis' => 'JD-10',
                'nama_jenis' => 'Data Excel',
                'keterangan' => 'Data atau rekapitulasi dalam format Excel',
            ],
            [
                'kode_jenis' => 'JD-11',
                'nama_jenis' => 'Lainnya',
                'keterangan' => 'Jenis dokumen lain yang belum tersedia',
            ],
        ];

        foreach ($jenisDokumen as $jenis) {
            JenisDokumen::create($jenis);
        }
    }
}