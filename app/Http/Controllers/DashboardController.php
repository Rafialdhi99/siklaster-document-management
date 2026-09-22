<?php

namespace App\Http\Controllers;

use App\Models\Klaster;
use App\Models\Program;
use App\Models\JenisDokumen;
use App\Models\Dokumen;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Data Dasar
        |--------------------------------------------------------------------------
        */

        $jumlahKlaster = Klaster::count();

        $jumlahProgram = Program::count();

        $klasters = Klaster::orderBy('id')->get();

        $programs = Program::orderBy('klaster_id')
            ->orderBy('id')
            ->get();

        $jenisDokumens = JenisDokumen::orderBy('id')->get();


        /*
        |--------------------------------------------------------------------------
        | Query Seluruh Dokumen
        |--------------------------------------------------------------------------
        */

        $dokumenQuery = Dokumen::query();


        /*
        |--------------------------------------------------------------------------
        | Statistik Dokumen
        |--------------------------------------------------------------------------
        */

        $jumlahDokumen = (clone $dokumenQuery)
            ->count();

        $jumlahMenungguVerifikasi = (clone $dokumenQuery)
            ->where('status', 'menunggu_verifikasi')
            ->count();

        $jumlahTerverifikasi = (clone $dokumenQuery)
            ->where('status', 'terverifikasi')
            ->count();

        $jumlahDitolak = (clone $dokumenQuery)
            ->where('status', 'ditolak')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Jumlah Dokumen per Klaster
        |--------------------------------------------------------------------------
        */

        $dokumenPerKlaster = Klaster::withCount('dokumens')
            ->orderBy('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kepatuhan / Status Dokumen per Program
        |--------------------------------------------------------------------------
        |
        | Persentase ini menunjukkan tingkat dokumen yang telah
        | terverifikasi dari seluruh dokumen yang tercatat.
        |
        */

        $kepatuhanProgram = Program::with('klaster')
            ->withCount([
                'dokumens as total_dokumen',

                'dokumens as terverifikasi_count' => function ($query) {
                    $query->where('status', 'terverifikasi');
                },

                'dokumens as menunggu_count' => function ($query) {
                    $query->where('status', 'menunggu_verifikasi');
                },

                'dokumens as ditolak_count' => function ($query) {
                    $query->where('status', 'ditolak');
                },
            ])
            ->orderBy('klaster_id')
            ->orderBy('id')
            ->get()
            ->map(function ($program) {

                if ($program->total_dokumen > 0) {

                    $program->tingkat_verifikasi = round(
                        ($program->terverifikasi_count / $program->total_dokumen) * 100,
                        1
                    );

                } else {

                    $program->tingkat_verifikasi = 0;
                }

                return $program;
            });


        /*
        |--------------------------------------------------------------------------
        | Dokumen Terbaru
        |--------------------------------------------------------------------------
        */

        $dokumenTerbaru = Dokumen::with([
            'user',
            'klaster',
            'program',
            'jenisDokumen'
        ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kirim Data ke Dashboard
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'jumlahKlaster',
            'jumlahProgram',
            'jumlahDokumen',
            'jumlahMenungguVerifikasi',
            'jumlahTerverifikasi',
            'jumlahDitolak',
            'dokumenPerKlaster',
            'dokumenTerbaru',
            'klasters',
            'programs',
            'jenisDokumens',
            'kepatuhanProgram'
        ));
    }
}