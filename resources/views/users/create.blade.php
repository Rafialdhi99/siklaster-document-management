@extends('layouts.app')

@section('title', 'Tambah Pengguna - SIKLASTER')
@section('page-title', 'Tambah Pengguna')

@push('styles')
<style>
    .user-form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .user-form-header {
        background: #172033;
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .user-form-header h2 {
        margin: 0 0 5px;
        font-size: 25px;
    }

    .user-form-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }

    .user-form-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: bold;
        color: #374151;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-size: 14px;
        font-family: Arial, Helvetica, sans-serif;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    .form-help {
        margin-top: 6px;
        font-size: 12px;
        color: #6b7280;
    }

    .error-message {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-back {
        display: inline-block;
        padding: 11px 18px;
        border-radius: 7px;
        text-decoration: none;
        background: #e5e7eb;
        color: #374151;
        font-size: 14px;
        font-weight: bold;
    }

    .btn-back:hover {
        background: #d1d5db;
    }

    .btn-save {
        padding: 11px 20px;
        border: none;
        border-radius: 7px;
        background: #2563eb;
        color: white;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #1d4ed8;
    }

    .role-info {
        background: #eff6ff;
        border-left: 4px solid #2563eb;
        padding: 12px 15px;
        margin-bottom: 25px;
        border-radius: 6px;
        font-size: 13px;
        color: #1e40af;
    }
</style>
@endpush

@section('content')

<div class="user-form-container">

    <div class="user-form-header">
        <h2>Tambah Pengguna</h2>
        <p>Tambahkan akun pengguna baru ke dalam sistem SIKLASTER.</p>
    </div>

    <div class="user-form-card">

        <div class="role-info">
            <strong>Admin</strong> dapat mengakses seluruh fitur termasuk Verifikasi Dokumen
            dan Manajemen Pengguna.
            <br>
            <strong>User</strong> dapat mengelola dokumen sesuai hak akses yang diberikan.
        </div>

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <div class="form-group">

                <label for="name">
                    Nama Pengguna
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Petugas KIA"
                    required
                    autofocus
                >

                @error('name')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="contoh@email.com"
                    required
                >

                @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="role">
                    Hak Akses
                </label>

                <select
                    id="role"
                    name="role"
                    required
                >
                    <option value="">
                        -- Pilih Hak Akses --
                    </option>

                    <option
                        value="user"
                        {{ old('role') === 'user' ? 'selected' : '' }}
                    >
                        User
                    </option>

                    <option
                        value="admin"
                        {{ old('role') === 'admin' ? 'selected' : '' }}
                    >
                        Admin
                    </option>

                </select>

                @error('role')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimal 6 karakter"
                    required
                >

                <div class="form-help">
                    Gunakan password yang mudah diingat tetapi tidak mudah ditebak.
                </div>

                @error('password')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                >

            </div>


            <div class="form-footer">

                <a
                    href="{{ route('users.index') }}"
                    class="btn-back"
                >
                    ← Kembali
                </a>

                <button
                    type="submit"
                    class="btn-save"
                >
                    💾 Simpan Pengguna
                </button>

            </div>

        </form>

    </div>

</div>

@endsection