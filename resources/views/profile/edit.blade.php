@extends('layouts.app')

@section('page-title', 'Profil Saya')

@push('styles')
<style>
    .profile-wrapper {
        max-width: 950px;
        margin: 0 auto;
    }

    .profile-header {
        margin-bottom: 24px;
    }

    .profile-header h2 {
        margin: 0 0 7px;
        color: #075985;
        font-size: 25px;
    }

    .profile-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 28px;
        margin-bottom: 24px;

        border: 1px solid #e2e8f0;

        box-shadow:
            0 5px 18px
            rgba(15, 23, 42, 0.05);
    }

    .profile-card-title {
        margin-bottom: 22px;
        padding-bottom: 15px;

        border-bottom:
            1px solid #e2e8f0;
    }

    .profile-card-title h3 {
        margin: 0 0 6px;

        font-size: 18px;
        color: #075985;
    }

    .profile-card-title p {
        margin: 0;

        color: #64748b;
        font-size: 13px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;

        margin-bottom: 7px;

        font-size: 13px;
        font-weight: 700;

        color: #334155;
    }

    .form-control {
        width: 100%;

        padding: 11px 13px;

        border:
            1px solid #cbd5e1;

        border-radius: 8px;

        font-size: 14px;

        outline: none;

        transition: 0.2s;

        background: #fff;
        color: #1e293b;
    }

    .form-control:focus {
        border-color: #0ea5a4;

        box-shadow:
            0 0 0 3px
            rgba(14, 165, 164, 0.12);
    }

    .form-control[readonly] {
        background: #f8fafc;
        cursor: not-allowed;
    }

    .form-error {
        margin-top: 6px;

        color: #dc2626;
        font-size: 12px;
    }

    .btn-save {
        border: none;

        padding: 11px 18px;

        border-radius: 8px;

        background:
            linear-gradient(
                90deg,
                #075985,
                #0ea5a4
            );

        color: white;

        font-size: 13px;
        font-weight: 700;

        cursor: pointer;

        transition: 0.2s;
    }

    .btn-save:hover {
        transform: translateY(-1px);

        box-shadow:
            0 5px 12px
            rgba(7, 89, 133, 0.18);
    }

    .success-message {
        margin-bottom: 22px;

        padding: 13px 16px;

        border-radius: 9px;

        background: #dcfce7;

        border:
            1px solid #86efac;

        color: #166534;

        font-size: 13px;
        font-weight: 600;
    }

    .user-info-box {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;

        margin-bottom: 22px;
    }

    .user-info-item {
        padding: 15px;

        border-radius: 9px;

        background: #f8fafc;

        border:
            1px solid #e2e8f0;
    }

    .user-info-label {
        margin-bottom: 5px;

        color: #64748b;

        font-size: 11px;

        text-transform: uppercase;

        letter-spacing: .5px;
    }

    .user-info-value {
        color: #0f172a;

        font-size: 14px;
        font-weight: 700;

        word-break: break-word;
    }

    .password-note {
        padding: 12px 14px;

        margin-bottom: 20px;

        border-radius: 8px;

        background: #eff6ff;

        color: #1e40af;

        font-size: 12px;

        line-height: 1.6;
    }

    @media (max-width: 650px) {

        .profile-card {
            padding: 20px;
        }

        .user-info-box {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush


@section('content')

<div class="profile-wrapper">

    <div class="profile-header">

        <h2>
            👤 Profil Saya
        </h2>

        <p>
            Kelola informasi akun dan keamanan password SIKLASTER.
        </p>

    </div>


    {{-- PESAN BERHASIL --}}

    @if(session('status') === 'profile-updated')

        <div class="success-message">
            ✅ Profil berhasil diperbarui.
        </div>

    @endif


    @if(session('status') === 'password-updated')

        <div class="success-message">
            ✅ Password berhasil diperbarui.
        </div>

    @endif



    {{-- =====================================================
         INFORMASI AKUN
    ====================================================== --}}

    <div class="profile-card">

        <div class="profile-card-title">

            <h3>
                Informasi Akun
            </h3>

            <p>
                Informasi akun yang sedang digunakan untuk masuk ke SIKLASTER.
            </p>

        </div>


        <div class="user-info-box">

            <div class="user-info-item">

                <div class="user-info-label">
                    Nama
                </div>

                <div class="user-info-value">
                    {{ auth()->user()->name }}
                </div>

            </div>


            <div class="user-info-item">

                <div class="user-info-label">
                    Role
                </div>

                <div class="user-info-value">
                    {{ ucfirst(auth()->user()->role) }}
                </div>

            </div>

        </div>



        <form
            method="POST"
            action="{{ route('profile.update') }}"
        >

            @csrf
            @method('PATCH')


            {{-- NAMA --}}

            <div class="form-group">

                <label for="name">
                    Nama Lengkap
                </label>

                <input
                    id="name"
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                    autocomplete="name"
                >

                @error('name')

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- EMAIL --}}

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                    autocomplete="email"
                >

                @error('email')

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- ROLE --}}

            <div class="form-group">

                <label>
                    Hak Akses
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ ucfirst(auth()->user()->role) }}"
                    readonly
                >

            </div>


            <button
                type="submit"
                class="btn-save"
            >
                💾 Simpan Perubahan Profil
            </button>

        </form>

    </div>



    {{-- =====================================================
         GANTI PASSWORD
    ====================================================== --}}

    <div class="profile-card">

        <div class="profile-card-title">

            <h3>
                🔐 Ganti Password
            </h3>

            <p>
                Gunakan password yang kuat dan jangan memberikannya kepada orang lain.
            </p>

        </div>


        <div class="password-note">
            Untuk keamanan akun, masukkan password lama terlebih dahulu sebelum membuat password baru.
        </div>


        <form
            method="POST"
            action="{{ route('password.update') }}"
        >

            @csrf
            @method('PUT')


            {{-- PASSWORD SEKARANG --}}

            <div class="form-group">

                <label for="current_password">
                    Password Saat Ini
                </label>

                <input
                    id="current_password"
                    type="password"
                    name="current_password"
                    class="form-control"
                    required
                    autocomplete="current-password"
                >

                @error(
                    'current_password',
                    'updatePassword'
                )

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- PASSWORD BARU --}}

            <div class="form-group">

                <label for="password">
                    Password Baru
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-control"
                    required
                    autocomplete="new-password"
                >

                @error(
                    'password',
                    'updatePassword'
                )

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>



            {{-- KONFIRMASI PASSWORD --}}

            <div class="form-group">

                <label for="password_confirmation">
                    Konfirmasi Password Baru
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    required
                    autocomplete="new-password"
                >

                @error(
                    'password_confirmation',
                    'updatePassword'
                )

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <button
                type="submit"
                class="btn-save"
            >
                🔑 Ganti Password
            </button>

        </form>

    </div>

</div>

@endsection