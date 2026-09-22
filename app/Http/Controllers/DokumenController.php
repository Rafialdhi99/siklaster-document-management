<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Klaster;
use App\Models\Program;
use App\Models\JenisDokumen;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
{
    $query = Dokumen::with([
        'user',
        'klaster',
        'program',
        'jenisDokumen'
    ]);

    /*
    |--------------------------------------------------------------------------
    | PENCARIAN
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where(
                'kode_dokumen',
                'like',
                '%' . $search . '%'
            )
            ->orWhere(
                'nama_dokumen',
                'like',
                '%' . $search . '%'
            )
            ->orWhere(
                'nama_file',
                'like',
                '%' . $search . '%'
            )
            ->orWhere(
                'deskripsi',
                'like',
                '%' . $search . '%'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER KLASTER
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
    | FILTER PROGRAM
    |--------------------------------------------------------------------------
    */

    if ($request->filled('program_id')) {
        $query->where(
            'program_id',
            $request->program_id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER TAHUN
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
    | FILTER STATUS
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
    | FILTER JENIS DOKUMEN
    |--------------------------------------------------------------------------
    */

    if ($request->filled('jenis_dokumen_id')) {
        $query->where(
            'jenis_dokumen_id',
            $request->jenis_dokumen_id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER PERIODE
    |--------------------------------------------------------------------------
    */

    if ($request->filled('periode')) {
        $query->where(
            'periode',
            $request->periode
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER PENGUNGGAH
    |--------------------------------------------------------------------------
    */

    if ($request->filled('user_id')) {
        $query->where(
            'user_id',
            $request->user_id
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DATA DOKUMEN
    |--------------------------------------------------------------------------
    */

    $dokumens = $query
        ->latest()
        ->get();

    /*
    |--------------------------------------------------------------------------
    | DATA UNTUK FILTER
    |--------------------------------------------------------------------------
    */

    $klasters = Klaster::orderBy('id')
        ->get();

    $programs = Program::orderBy('klaster_id')
        ->orderBy('id')
        ->get();

    $jenisDokumens = JenisDokumen::orderBy('id')
        ->get();

    $users = User::orderBy('name')
        ->get();

    $years = Dokumen::select('tahun')
        ->whereNotNull('tahun')
        ->distinct()
        ->orderByDesc('tahun')
        ->pluck('tahun');

    $periodes = Dokumen::select('periode')
        ->whereNotNull('periode')
        ->where('periode', '!=', '')
        ->distinct()
        ->pluck('periode');

    return view(
        'dokumens.index',
        compact(
            'dokumens',
            'klasters',
            'programs',
            'jenisDokumens',
            'users',
            'years',
            'periodes'
        )
    );
}


    /*
    |--------------------------------------------------------------------------
    | DETAIL DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function show(Dokumen $dokumen)
    {
        $dokumen->load([
            'user',
            'klaster',
            'program',
            'jenisDokumen',
            'riwayats.user'
        ]);

        return view(
            'dokumens.show',
            compact('dokumen')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIEW PDF / GAMBAR
    |--------------------------------------------------------------------------
    */

    public function preview(Dokumen $dokumen)
    {
        if (
            !Storage::disk('local')
                ->exists($dokumen->file_path)
        ) {
            abort(
                404,
                'File tidak ditemukan.'
            );
        }

        $path = Storage::disk('local')
            ->path($dokumen->file_path);

        $extension = strtolower(
            pathinfo(
                $dokumen->nama_file,
                PATHINFO_EXTENSION
            )
        );

        $mimeTypes = [

            'pdf' => 'application/pdf',

            'jpg' => 'image/jpeg',

            'jpeg' => 'image/jpeg',

            'png' => 'image/png',

        ];

        if (
            !array_key_exists(
                $extension,
                $mimeTypes
            )
        ) {
            abort(
                415,
                'Format file ini tidak mendukung preview langsung di browser.'
            );
        }

        return response()->file(
            $path,
            [
                'Content-Type' =>
                    $mimeTypes[$extension],

                'Content-Disposition' =>
                    'inline; filename="' .
                    addslashes(
                        $dokumen->nama_file
                    ) .
                    '"',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD FILE ASLI
    |--------------------------------------------------------------------------
    */

    public function download(Dokumen $dokumen)
    {
        if (
            !Storage::disk('local')
                ->exists($dokumen->file_path)
        ) {
            abort(
                404,
                'File tidak ditemukan.'
            );
        }

        return Storage::disk('local')
            ->download(
                $dokumen->file_path,
                $dokumen->nama_file
            );
    }


        /*
    |--------------------------------------------------------------------------
    | HAPUS DOKUMEN / PINDAHKAN KE SAMPAH
    |--------------------------------------------------------------------------
    */

    public function destroy(Dokumen $dokumen)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ATURAN USER BIASA
        |--------------------------------------------------------------------------
        */

        if ($user->role !== 'admin') {

            // Hanya boleh menghapus dokumen miliknya sendiri
            if ($dokumen->user_id !== $user->id) {
                abort(
                    403,
                    'Anda tidak memiliki izin untuk menghapus dokumen ini.'
                );
            }

            // Dokumen terverifikasi tidak boleh dihapus user
            if ($dokumen->status === 'terverifikasi') {
                return back()->with(
                    'error',
                    'Dokumen yang sudah terverifikasi tidak dapat dihapus.'
                );
            }

            // User hanya boleh menghapus dokumen
            // yang menunggu verifikasi atau ditolak
            if (
                !in_array(
                    $dokumen->status,
                    [
                        'menunggu_verifikasi',
                        'ditolak'
                    ]
                )
            ) {
                return back()->with(
                    'error',
                    'Dokumen ini tidak dapat dihapus.'
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SOFT DELETE
        |--------------------------------------------------------------------------
        |
        | File fisik tetap disimpan.
        | Dokumen hanya dipindahkan ke Sampah.
        |
        */

        $namaDokumen = $dokumen->nama_dokumen;

        $dokumen->delete();

        ActivityLogger::log(
            'hapus_dokumen',
            'Memindahkan dokumen ke Sampah: ' . $namaDokumen,
            $dokumen
        );

        return redirect()
            ->route('dokumens.index')
            ->with(
                'success',
                'Dokumen berhasil dipindahkan ke Sampah.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SAMPAH DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function sampah()
    {
        $dokumens = Dokumen::onlyTrashed()
            ->with([
                'user',
                'klaster',
                'program',
                'jenisDokumen'
            ])
            ->latest('deleted_at')
            ->get();

        return view(
            'dokumens.sampah',
            compact('dokumens')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PULIHKAN DOKUMEN DARI SAMPAH
    |--------------------------------------------------------------------------
    */

    public function restore($id)
    {
        $dokumen = Dokumen::onlyTrashed()
            ->findOrFail($id);

        $namaDokumen = $dokumen->nama_dokumen;

        $dokumen->restore();

        ActivityLogger::log(
            'pulihkan_dokumen',
            'Memulihkan dokumen dari Sampah: ' . $namaDokumen,
            $dokumen
        );

        return redirect()
            ->route('dokumens.sampah')
            ->with(
                'success',
                'Dokumen berhasil dipulihkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS PERMANEN DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function forceDelete($id)
    {
        $dokumen = Dokumen::onlyTrashed()
            ->findOrFail($id);

        $namaDokumen = $dokumen->nama_dokumen;

        /*
        |--------------------------------------------------------------------------
        | HAPUS FILE FISIK
        |--------------------------------------------------------------------------
        */

        if (
            $dokumen->file_path &&
            Storage::disk('local')
                ->exists($dokumen->file_path)
        ) {
            Storage::disk('local')
                ->delete($dokumen->file_path);
        }

        /*
        |--------------------------------------------------------------------------
        | AUDIT TRAIL
        |--------------------------------------------------------------------------
        */

        ActivityLogger::log(
            'hapus_permanen_dokumen',
            'Menghapus permanen dokumen dari Sampah: ' . $namaDokumen,
            $dokumen
        );

        /*
        |--------------------------------------------------------------------------
        | HAPUS PERMANEN DARI DATABASE
        |--------------------------------------------------------------------------
        */

        $dokumen->forceDelete();

        return redirect()
            ->route('dokumens.sampah')
            ->with(
                'success',
                'Dokumen berhasil dihapus permanen.'
            );
    }
}