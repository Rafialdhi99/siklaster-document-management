<?php

namespace App\Http\Controllers;

use App\Models\Klaster;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Halaman Penugasan
    |--------------------------------------------------------------------------
    |
    | User hanya boleh memilih penugasan SATU KALI.
    | Jika sudah memiliki program, halaman penugasan tidak dapat dibuka lagi.
    |
    */

    public function edit()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Admin Tidak Memerlukan Penugasan
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return redirect()
                ->route('dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Penugasan Sudah Pernah Disimpan
        |--------------------------------------------------------------------------
        */

        if ($user->programs()->exists()) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'info',
                    'Penugasan Anda sudah tersimpan dan tidak dapat diubah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Klaster dan Program
        |--------------------------------------------------------------------------
        */

        $klasters = Klaster::with('programs')
            ->orderBy('id')
            ->get();

        $programTerpilih = [];

        return view(
            'penugasan.edit',
            compact(
                'user',
                'klasters',
                'programTerpilih'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Penugasan
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Admin Tidak Memerlukan Penugasan
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {
            return redirect()
                ->route('dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | Cegah Perubahan Penugasan
        |--------------------------------------------------------------------------
        |
        | Pengecekan ini penting.
        | Jadi bukan hanya halaman yang dikunci, tetapi request langsung
        | ke server juga tidak bisa digunakan untuk mengganti program.
        |
        */

        if ($user->programs()->exists()) {
            return redirect()
                ->route('dashboard')
                ->with(
                    'error',
                    'Penugasan sudah tersimpan dan tidak dapat diubah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'programs' => [
                'required',
                'array',
                'min:1',
            ],

            'programs.*' => [
                'integer',
                'exists:programs,id',
            ],
        ], [
            'programs.required' =>
                'Silakan pilih minimal satu program.',

            'programs.array' =>
                'Pilihan program tidak valid.',

            'programs.min' =>
                'Silakan pilih minimal satu program.',

            'programs.*.exists' =>
                'Program yang dipilih tidak valid.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan Penugasan Pertama
        |--------------------------------------------------------------------------
        */

        $user->programs()->sync(
            $validated['programs']
        );

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Penugasan berhasil disimpan.'
            );
    }
}