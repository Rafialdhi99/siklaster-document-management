<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Pengguna
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $users = User::orderBy('name')->get();

        return view(
            'users.index',
            compact('users')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Form Tambah Pengguna
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('users.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Pengguna
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                'in:admin,user',
            ],

        ]);


        User::create([

            'name' =>
                $request->name,

            'email' =>
                $request->email,

            'password' =>
                Hash::make(
                    $request->password
                ),

            'role' =>
                $request->role,

        ]);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Form Edit Pengguna
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {
        return view(
            'users.edit',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Pengguna
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {

        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'role' => [
                'required',
                'in:admin,user',
            ],

            'password' => [
                'nullable',
                'min:8',
                'confirmed',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Pengamanan Role Admin
        |--------------------------------------------------------------------------
        |
        | Admin yang sedang login tidak boleh
        | mengubah role dirinya sendiri.
        |
        */

        if ($user->id === auth()->id()) {

            $user->name =
                $request->name;

            $user->email =
                $request->email;

            /*
            | Role akun sendiri tetap admin
            */

            $user->role =
                'admin';

        } else {

            $user->name =
                $request->name;

            $user->email =
                $request->email;

            $user->role =
                $request->role;
        }


        /*
        |--------------------------------------------------------------------------
        | Ubah Password
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $user->password =
                Hash::make(
                    $request->password
                );
        }


        $user->save();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Pengguna
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {
        /*
        |--------------------------------------------------------------------------
        | Tidak Boleh Menghapus Akun Sendiri
        |--------------------------------------------------------------------------
        */

        if ($user->id === auth()->id()) {

            return redirect()
                ->route('users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun yang sedang digunakan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Admin Terakhir Tidak Boleh Dihapus
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {

            $jumlahAdmin =
                User::where(
                    'role',
                    'admin'
                )->count();


            if ($jumlahAdmin <= 1) {

                return redirect()
                    ->route('users.index')
                    ->with(
                        'error',
                        'Admin terakhir tidak dapat dihapus.'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Hapus Pengguna
        |--------------------------------------------------------------------------
        */

        $user->delete();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Pengguna berhasil dihapus.'
            );
    }
}