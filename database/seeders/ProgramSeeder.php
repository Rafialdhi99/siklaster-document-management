<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [

            // KLASTER 1 - MANAJEMEN
            [
                'klaster_id' => 1,
                'kode_program' => 'K1-01',
                'nama_program' => 'Manajemen, perencanaan, keuangan, dan tata usaha',
                'keterangan' => 'Perencanaan, pengelolaan keuangan, administrasi dan tata usaha Puskesmas',
            ],
            [
                'klaster_id' => 1,
                'kode_program' => 'K1-02',
                'nama_program' => 'Manajemen SDM dan logistik',
                'keterangan' => 'Pengelolaan sumber daya manusia dan logistik Puskesmas',
            ],
            [
                'klaster_id' => 1,
                'kode_program' => 'K1-03',
                'nama_program' => 'Sistem informasi dan data Puskesmas',
                'keterangan' => 'Pengelolaan sistem informasi dan data Puskesmas',
            ],
            [
                'klaster_id' => 1,
                'kode_program' => 'K1-04',
                'nama_program' => 'Manajemen mutu',
                'keterangan' => 'Pengelolaan dan peningkatan mutu pelayanan Puskesmas',
            ],

            // KLASTER 2 - IBU DAN ANAK
            [
                'klaster_id' => 2,
                'kode_program' => 'K2-01',
                'nama_program' => 'Pelayanan kesehatan ibu hamil, bersalin, dan nifas',
                'keterangan' => 'Pelayanan kesehatan ibu selama masa kehamilan, persalinan, dan nifas',
            ],
            [
                'klaster_id' => 2,
                'kode_program' => 'K2-02',
                'nama_program' => 'Kesehatan bayi, anak prasekolah, dan balita',
                'keterangan' => 'Pelayanan kesehatan bayi, anak prasekolah, dan balita',
            ],
            [
                'klaster_id' => 2,
                'kode_program' => 'K2-03',
                'nama_program' => 'Kesehatan anak usia sekolah dan remaja',
                'keterangan' => 'Pelayanan kesehatan anak usia sekolah dan remaja',
            ],

            // KLASTER 3 - USIA DEWASA DAN LANJUT USIA
            [
                'klaster_id' => 3,
                'kode_program' => 'K3-01',
                'nama_program' => 'Pelayanan kesehatan usia dewasa',
                'keterangan' => 'Pelayanan kesehatan kelompok usia dewasa',
            ],
            [
                'klaster_id' => 3,
                'kode_program' => 'K3-02',
                'nama_program' => 'Pelayanan kesehatan lanjut usia',
                'keterangan' => 'Pelayanan kesehatan lanjut usia atau lansia',
            ],
            [
                'klaster_id' => 3,
                'kode_program' => 'K3-03',
                'nama_program' => 'Skrining kesehatan usia produktif dan geriatri',
                'keterangan' => 'Skrining kesehatan usia produktif dan geriatri',
            ],

            // KLASTER 4 - PENANGGULANGAN PENYAKIT MENULAR
            [
                'klaster_id' => 4,
                'kode_program' => 'K4-01',
                'nama_program' => 'Surveilans penyakit dan pengawasan lingkungan',
                'keterangan' => 'Surveilans penyakit dan pengawasan faktor lingkungan',
            ],
            [
                'klaster_id' => 4,
                'kode_program' => 'K4-02',
                'nama_program' => 'Program imunisasi',
                'keterangan' => 'Pelaksanaan dan pengelolaan program imunisasi',
            ],
            [
                'klaster_id' => 4,
                'kode_program' => 'K4-03',
                'nama_program' => 'Pengendalian TB, HIV/AIDS, malaria, kusta, dan diare',
                'keterangan' => 'Pengendalian dan penanggulangan penyakit menular prioritas',
            ],

            // KLASTER 5 - LINTAS KLASTER
            [
                'klaster_id' => 5,
                'kode_program' => 'K5-01',
                'nama_program' => 'Pelayanan gawat darurat',
                'keterangan' => 'Pelayanan kegawatdaruratan atau UGD',
            ],
            [
                'klaster_id' => 5,
                'kode_program' => 'K5-02',
                'nama_program' => 'Pelayanan kefarmasian',
                'keterangan' => 'Pelayanan dan pengelolaan kefarmasian',
            ],
            [
                'klaster_id' => 5,
                'kode_program' => 'K5-03',
                'nama_program' => 'Pelayanan laboratorium',
                'keterangan' => 'Pelayanan pemeriksaan laboratorium',
            ],
            [
                'klaster_id' => 5,
                'kode_program' => 'K5-04',
                'nama_program' => 'Pelayanan kesehatan gigi dan mulut',
                'keterangan' => 'Pelayanan kesehatan gigi dan mulut',
            ],
            [
                'klaster_id' => 5,
                'kode_program' => 'K5-05',
                'nama_program' => 'Rawat inap dan penanganan krisis kesehatan',
                'keterangan' => 'Pelayanan rawat inap jika tersedia dan penanganan krisis kesehatan',
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}