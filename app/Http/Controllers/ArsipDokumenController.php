<?php

namespace App\Http\Controllers;

use App\Models\Klaster;
use App\Models\Program;
use App\Models\Dokumen;

class ArsipDokumenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Halaman Utama Arsip
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (auth()->user()->role === 'admin') {

            $klasters = Klaster::withCount('dokumens')
                ->orderBy('id')
                ->get();

        } else {

            $klasters = Klaster::withCount([
                'dokumens as dokumens_count' => function ($query) {
                    $query->where('user_id', auth()->id());
                }
            ])
            ->orderBy('id')
            ->get();
        }


        $dokumenQuery = Dokumen::query();

        if (auth()->user()->role !== 'admin') {
            $dokumenQuery->where('user_id', auth()->id());
        }

        $jumlahDokumenArsip = $dokumenQuery->count();


        $tahunQuery = Dokumen::query();

        if (auth()->user()->role !== 'admin') {
            $tahunQuery->where('user_id', auth()->id());
        }

        $jumlahTahun = $tahunQuery
            ->whereNotNull('tahun')
            ->distinct()
            ->count('tahun');


        return view(
            'arsip.index',
            compact(
                'klasters',
                'jumlahDokumenArsip',
                'jumlahTahun'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Arsip Berdasarkan Klaster
    |--------------------------------------------------------------------------
    */

    public function klaster(Klaster $klaster)
    {
        if (auth()->user()->role === 'admin') {

            $programs = Program::where(
                    'klaster_id',
                    $klaster->id
                )
                ->withCount('dokumens')
                ->orderBy('id')
                ->get();

        } else {

            $programs = Program::where(
                    'klaster_id',
                    $klaster->id
                )
                ->withCount([
                    'dokumens as dokumens_count' => function ($query) {
                        $query->where('user_id', auth()->id());
                    }
                ])
                ->orderBy('id')
                ->get();
        }


        $dokumenQuery = Dokumen::where(
            'klaster_id',
            $klaster->id
        );

        if (auth()->user()->role !== 'admin') {
            $dokumenQuery->where('user_id', auth()->id());
        }

        $jumlahDokumenKlaster = $dokumenQuery->count();


        $tahunQuery = Dokumen::where(
            'klaster_id',
            $klaster->id
        );

        if (auth()->user()->role !== 'admin') {
            $tahunQuery->where('user_id', auth()->id());
        }

        $jumlahTahunKlaster = $tahunQuery
            ->whereNotNull('tahun')
            ->distinct()
            ->count('tahun');


        return view(
            'arsip.klaster',
            compact(
                'klaster',
                'programs',
                'jumlahDokumenKlaster',
                'jumlahTahunKlaster'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Arsip Berdasarkan Program
    |--------------------------------------------------------------------------
    */

    public function program(Program $program)
    {
        $program->load('klaster');


        $dokumenQuery = Dokumen::where(
            'program_id',
            $program->id
        );

        if (auth()->user()->role !== 'admin') {
            $dokumenQuery->where('user_id', auth()->id());
        }


        $jumlahDokumenProgram =
            (clone $dokumenQuery)->count();


        $tahunDokumens = (clone $dokumenQuery)
            ->whereNotNull('tahun')
            ->select('tahun')
            ->selectRaw('COUNT(*) as jumlah_dokumen')
            ->groupBy('tahun')
            ->orderByDesc('tahun')
            ->get();


        $jumlahTahunProgram =
            $tahunDokumens->count();


        $jumlahMenunggu =
            (clone $dokumenQuery)
                ->where('status', 'menunggu_verifikasi')
                ->count();


        $jumlahTerverifikasi =
            (clone $dokumenQuery)
                ->where('status', 'terverifikasi')
                ->count();


        $jumlahDitolak =
            (clone $dokumenQuery)
                ->where('status', 'ditolak')
                ->count();


        return view(
            'arsip.program',
            compact(
                'program',
                'tahunDokumens',
                'jumlahDokumenProgram',
                'jumlahTahunProgram',
                'jumlahMenunggu',
                'jumlahTerverifikasi',
                'jumlahDitolak'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Arsip Berdasarkan Tahun
    |--------------------------------------------------------------------------
    */

    public function tahun(
        Program $program,
        $tahun
    ) {
        $program->load('klaster');


        $dokumenQuery = Dokumen::where(
            'program_id',
            $program->id
        )
        ->where(
            'tahun',
            $tahun
        );


        if (auth()->user()->role !== 'admin') {
            $dokumenQuery->where(
                'user_id',
                auth()->id()
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Daftar 12 Bulan
        |--------------------------------------------------------------------------
        */

        $daftarPeriode = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];


        /*
        |--------------------------------------------------------------------------
        | Hitung Dokumen per Periode
        |--------------------------------------------------------------------------
        */

        $jumlahPerPeriode = (clone $dokumenQuery)
            ->whereNotNull('periode')
            ->select('periode')
            ->selectRaw('COUNT(*) as jumlah_dokumen')
            ->groupBy('periode')
            ->pluck(
                'jumlah_dokumen',
                'periode'
            );


        /*
        |--------------------------------------------------------------------------
        | Bentuk Data 12 Bulan
        |--------------------------------------------------------------------------
        */

        $periodeDokumens = collect(
            $daftarPeriode
        )->map(function ($periode) use ($jumlahPerPeriode) {

            return (object) [
                'periode' => $periode,
                'jumlah_dokumen' =>
                    $jumlahPerPeriode[$periode] ?? 0,
            ];

        });


        /*
        |--------------------------------------------------------------------------
        | Statistik Tahun
        |--------------------------------------------------------------------------
        */

        $jumlahDokumenTahun =
            (clone $dokumenQuery)->count();


        $jumlahPeriodeAktif =
            $periodeDokumens
                ->where(
                    'jumlah_dokumen',
                    '>',
                    0
                )
                ->count();


        $jumlahMenunggu =
            (clone $dokumenQuery)
                ->where(
                    'status',
                    'menunggu_verifikasi'
                )
                ->count();


        $jumlahTerverifikasi =
            (clone $dokumenQuery)
                ->where(
                    'status',
                    'terverifikasi'
                )
                ->count();


        $jumlahDitolak =
            (clone $dokumenQuery)
                ->where(
                    'status',
                    'ditolak'
                )
                ->count();


        return view(
            'arsip.tahun',
            compact(
                'program',
                'tahun',
                'periodeDokumens',
                'jumlahDokumenTahun',
                'jumlahPeriodeAktif',
                'jumlahMenunggu',
                'jumlahTerverifikasi',
                'jumlahDitolak'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Arsip Berdasarkan Periode
    |--------------------------------------------------------------------------
    */

    public function periode(
        Program $program,
        $tahun,
        $periode
    ) {
        $program->load('klaster');


        /*
        |--------------------------------------------------------------------------
        | Validasi Periode
        |--------------------------------------------------------------------------
        */

        $daftarPeriode = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];


        if (!in_array($periode, $daftarPeriode)) {

            abort(
                404,
                'Periode tidak ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Query Dokumen Periode
        |--------------------------------------------------------------------------
        */

        $dokumenQuery = Dokumen::with([
            'user',
            'klaster',
            'program',
            'jenisDokumen'
        ])
        ->where(
            'program_id',
            $program->id
        )
        ->where(
            'tahun',
            $tahun
        )
        ->where(
            'periode',
            $periode
        );


        if (auth()->user()->role !== 'admin') {

            $dokumenQuery->where(
                'user_id',
                auth()->id()
            );
        }


        $dokumens = $dokumenQuery
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Statistik Periode
        |--------------------------------------------------------------------------
        */

        $jumlahDokumenPeriode =
            $dokumens->count();


        $jumlahMenunggu =
            $dokumens
                ->where(
                    'status',
                    'menunggu_verifikasi'
                )
                ->count();


        $jumlahTerverifikasi =
            $dokumens
                ->where(
                    'status',
                    'terverifikasi'
                )
                ->count();


        $jumlahDitolak =
            $dokumens
                ->where(
                    'status',
                    'ditolak'
                )
                ->count();


        return view(
            'arsip.periode',
            compact(
                'program',
                'tahun',
                'periode',
                'dokumens',
                'jumlahDokumenPeriode',
                'jumlahMenunggu',
                'jumlahTerverifikasi',
                'jumlahDitolak'
            )
        );
    }
}