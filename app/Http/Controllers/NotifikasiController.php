<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Notifikasi
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query Notifikasi User Login
        |--------------------------------------------------------------------------
        */

        $query = Notifikasi::with('dokumen')
            ->where('user_id', auth()->id());


        /*
        |--------------------------------------------------------------------------
        | Filter Status Baca
        |--------------------------------------------------------------------------
        |
        | status:
        | - semua
        | - belum_dibaca
        | - sudah_dibaca
        |
        */

        $status = $request->get('status', 'semua');

        if ($status === 'belum_dibaca') {
            $query->where('dibaca', false);
        }

        if ($status === 'sudah_dibaca') {
            $query->where('dibaca', true);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Notifikasi
        |--------------------------------------------------------------------------
        */

        $notifikasis = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Statistik Notifikasi
        |--------------------------------------------------------------------------
        */

        $totalNotifikasi = Notifikasi::where(
            'user_id',
            auth()->id()
        )->count();

        $belumDibaca = Notifikasi::where(
            'user_id',
            auth()->id()
        )
            ->where('dibaca', false)
            ->count();

        $sudahDibaca = Notifikasi::where(
            'user_id',
            auth()->id()
        )
            ->where('dibaca', true)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Kirim ke View
        |--------------------------------------------------------------------------
        */

        return view('notifikasi.index', compact(
            'notifikasis',
            'totalNotifikasi',
            'belumDibaca',
            'sudahDibaca',
            'status'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | Buka Notifikasi
    |--------------------------------------------------------------------------
    */

    public function show(Notifikasi $notifikasi)
    {
        /*
        |--------------------------------------------------------------------------
        | Keamanan
        |--------------------------------------------------------------------------
        */

        if ($notifikasi->user_id !== auth()->id()) {
            abort(
                403,
                'Anda tidak memiliki akses ke notifikasi ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Tandai Sudah Dibaca
        |--------------------------------------------------------------------------
        */

        if (!$notifikasi->dibaca) {
            $notifikasi->update([
                'dibaca' => true,
                'dibaca_pada' => now(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Buka Dokumen Terkait
        |--------------------------------------------------------------------------
        */

        if ($notifikasi->dokumen_id && $notifikasi->dokumen) {
            return redirect()->route(
                'dokumens.show',
                $notifikasi->dokumen_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Dokumen Sudah Tidak Tersedia
        |--------------------------------------------------------------------------
        */

        if ($notifikasi->dokumen_id && !$notifikasi->dokumen) {
            return redirect()
                ->route('notifikasi.index')
                ->with(
                    'warning',
                    'Dokumen yang terkait dengan notifikasi ini sudah tidak tersedia.'
                );
        }


        return redirect()
            ->route('notifikasi.index');
    }


    /*
    |--------------------------------------------------------------------------
    | Tandai Satu Notifikasi Sudah Dibaca
    |--------------------------------------------------------------------------
    */

    public function tandaiDibaca(Notifikasi $notifikasi)
    {
        /*
        |--------------------------------------------------------------------------
        | Keamanan
        |--------------------------------------------------------------------------
        */

        if ($notifikasi->user_id !== auth()->id()) {
            abort(
                403,
                'Anda tidak memiliki akses ke notifikasi ini.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update Status
        |--------------------------------------------------------------------------
        */

        if (!$notifikasi->dibaca) {
            $notifikasi->update([
                'dibaca' => true,
                'dibaca_pada' => now(),
            ]);
        }


        return back()->with(
            'success',
            'Notifikasi ditandai sudah dibaca.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Tandai Semua Sudah Dibaca
    |--------------------------------------------------------------------------
    */

    public function tandaiSemuaDibaca(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Update Semua Notifikasi User Login
        |--------------------------------------------------------------------------
        */

        $jumlahDiubah = Notifikasi::where(
            'user_id',
            auth()->id()
        )
            ->where('dibaca', false)
            ->update([
                'dibaca' => true,
                'dibaca_pada' => now(),
            ]);


        /*
        |--------------------------------------------------------------------------
        | Pesan Hasil
        |--------------------------------------------------------------------------
        */

        if ($jumlahDiubah === 0) {
            return redirect()
                ->route('notifikasi.index')
                ->with(
                    'info',
                    'Tidak ada notifikasi baru yang perlu ditandai.'
                );
        }


        return redirect()
            ->route('notifikasi.index')
            ->with(
                'success',
                $jumlahDiubah . ' notifikasi telah ditandai sebagai sudah dibaca.'
            );
    }
}