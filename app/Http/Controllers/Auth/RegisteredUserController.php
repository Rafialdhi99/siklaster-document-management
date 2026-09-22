<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Menampilkan halaman registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi user baru.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buat User Baru
        |--------------------------------------------------------------------------
        |
        | Semua orang yang melakukan registrasi sendiri otomatis menjadi USER.
        | Role ADMIN tidak dapat dipilih melalui halaman registrasi.
        |
        */

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        event(new Registered($user));

        /*
        |--------------------------------------------------------------------------
        | Login Otomatis
        |--------------------------------------------------------------------------
        */

        Auth::login($user);

        /*
        |--------------------------------------------------------------------------
        | Arahkan ke Penugasan
        |--------------------------------------------------------------------------
        |
        | Setelah register, user wajib memilih program tanggung jawabnya.
        |
        */

        return redirect()
    ->route('dashboard')
    ->with(
        'success',
        'Registrasi berhasil. Selamat datang di SIKLASTER.'
    );
    }
}