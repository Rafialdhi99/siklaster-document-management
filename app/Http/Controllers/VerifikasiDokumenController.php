<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Klaster;
use App\Models\RiwayatDokumen;
use App\Models\Notifikasi;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class VerifikasiDokumenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dokumen Menunggu Verifikasi
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $dokumens = Dokumen::with([
            'user',
            'klaster',
            'program',
            'jenisDokumen'
        ])
        ->where('status', 'menunggu_verifikasi')
        ->latest()
        ->get();

        return view(
            'verifikasi.index',
            compact('dokumens')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Riwayat Verifikasi
    |--------------------------------------------------------------------------
    */

    public function riwayat(Request $request)
    {
        $query = Dokumen::with([
            'user',
            'klaster',
            'program',
            'jenisDokumen'
        ])
        ->whereIn('status', [
            'terverifikasi',
            'ditolak'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Pencarian
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'nama_dokumen',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhere(
                    'nama_file',
                    'like',
                    '%' . $search . '%'
                )

                ->orWhereHas('user', function ($userQuery) use ($search) {

                    $userQuery
                        ->where(
                            'name',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'email',
                            'like',
                            '%' . $search . '%'
                        );
                });
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Klaster
        |--------------------------------------------------------------------------
        */

        if ($request->filled('klaster_id')) {

            $query->where(
                'klaster_id',
                $request->klaster_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Tahun
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $query->where(
                'tahun',
                $request->tahun
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $dokumens = $query
            ->latest('updated_at')
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Data Filter
        |--------------------------------------------------------------------------
        */

        $klasters = Klaster::orderBy('id')
            ->get();

        $years = Dokumen::whereIn('status', [
                'terverifikasi',
                'ditolak'
            ])
            ->whereNotNull('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');


        return view(
            'verifikasi.riwayat',
            compact(
                'dokumens',
                'klasters',
                'years'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Setujui Dokumen
    |--------------------------------------------------------------------------
    */

    public function setujui(Dokumen $dokumen)
    {
        /*
        |--------------------------------------------------------------------------
        | Cegah Dokumen Diproses Dua Kali
        |--------------------------------------------------------------------------
        */

        if ($dokumen->status !== 'menunggu_verifikasi') {

            return redirect()
                ->route('verifikasi.index')
                ->with(
                    'error',
                    'Dokumen ini sudah diproses sebelumnya.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Status Sebelum
        |--------------------------------------------------------------------------
        */

        $statusSebelum = $dokumen->status;


        /*
        |--------------------------------------------------------------------------
        | Update Status Dokumen
        |--------------------------------------------------------------------------
        */

        $dokumen->update([
            'status' => 'terverifikasi',
            'alasan_penolakan' => null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Catat Audit Trail
        |--------------------------------------------------------------------------
        */

        RiwayatDokumen::create([

            'dokumen_id' =>
                $dokumen->id,

            'user_id' =>
                auth()->id(),

            'aksi' =>
                'diverifikasi',

            'status_sebelum' =>
                $statusSebelum,

            'status_sesudah' =>
                'terverifikasi',

            'keterangan' =>
                'Dokumen disetujui dan dinyatakan terverifikasi.',
        ]);

ActivityLogger::log(
    'approve_dokumen',
    'Menyetujui dokumen: ' . $dokumen->nama_dokumen,
    $dokumen
);
        /*
        |--------------------------------------------------------------------------
        | Buat Notifikasi untuk Pemilik Dokumen
        |--------------------------------------------------------------------------
        */

        if ($dokumen->user_id) {

            Notifikasi::create([

                'user_id' =>
                    $dokumen->user_id,

                'dokumen_id' =>
                    $dokumen->id,

                'jenis' =>
                    'terverifikasi',

                'judul' =>
                    'Dokumen Terverifikasi',

                'pesan' =>
                    'Dokumen "' .
                    $dokumen->nama_dokumen .
                    '" telah disetujui dan dinyatakan terverifikasi.',

                'dibaca' =>
                    false,

                'dibaca_pada' =>
                    null,
            ]);
        }


        return redirect()
            ->route('verifikasi.index')
            ->with(
                'success',
                'Dokumen berhasil diverifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Tolak Dokumen
    |--------------------------------------------------------------------------
    */

    public function tolak(
        Request $request,
        Dokumen $dokumen
    ) {

        /*
        |--------------------------------------------------------------------------
        | Cegah Dokumen Diproses Dua Kali
        |--------------------------------------------------------------------------
        */

        if ($dokumen->status !== 'menunggu_verifikasi') {

            return redirect()
                ->route('verifikasi.index')
                ->with(
                    'error',
                    'Dokumen ini sudah diproses sebelumnya.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'alasan_penolakan' => [
                'required',
                'string',
                'max:1000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan Status Sebelum
        |--------------------------------------------------------------------------
        */

        $statusSebelum = $dokumen->status;


        /*
        |--------------------------------------------------------------------------
        | Update Dokumen
        |--------------------------------------------------------------------------
        */

        $dokumen->update([

            'status' =>
                'ditolak',

            'alasan_penolakan' =>
                $validated['alasan_penolakan'],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Catat Audit Trail
        |--------------------------------------------------------------------------
        */

        RiwayatDokumen::create([

            'dokumen_id' =>
                $dokumen->id,

            'user_id' =>
                auth()->id(),

            'aksi' =>
                'ditolak',

            'status_sebelum' =>
                $statusSebelum,

            'status_sesudah' =>
                'ditolak',

            'keterangan' =>
                'Dokumen ditolak. Alasan: ' .
                $validated['alasan_penolakan'],
        ]);

ActivityLogger::log(
    'reject_dokumen',
    'Menolak dokumen: ' .
    $dokumen->nama_dokumen .
    '. Alasan: ' .
    $validated['alasan_penolakan'],
    $dokumen
);
        /*
        |--------------------------------------------------------------------------
        | Buat Notifikasi untuk Pemilik Dokumen
        |--------------------------------------------------------------------------
        */

        if ($dokumen->user_id) {

            Notifikasi::create([

                'user_id' =>
                    $dokumen->user_id,

                'dokumen_id' =>
                    $dokumen->id,

                'jenis' =>
                    'ditolak',

                'judul' =>
                    'Dokumen Ditolak',

                'pesan' =>
                    'Dokumen "' .
                    $dokumen->nama_dokumen .
                    '" ditolak. Alasan: ' .
                    $validated['alasan_penolakan'],

                'dibaca' =>
                    false,

                'dibaca_pada' =>
                    null,
            ]);
        }


        return redirect()
            ->route('verifikasi.index')
            ->with(
                'success',
                'Dokumen berhasil ditolak.'
            );
    }
}