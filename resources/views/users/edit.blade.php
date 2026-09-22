@extends('layouts.app')

@section('title', 'Edit Pengguna - SIKLASTER')
@section('page-title', 'Edit Pengguna')

@push('styles')
<style>
    .edit-user-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .edit-user-header {
        background: #172033;
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .edit-user-header h2 {
        margin: 0 0 5px;
        font-size: 25px;
    }

    .edit-user-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }

    .edit-user-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        font-size: 14px;
        color: #374151;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-size: 14px;
        font-family: Arial, sans-serif;
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
        gap: 10px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
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

    .btn-cancel {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 7px;
        background: #e5e7eb;
        color: #374151;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .btn-cancel:hover {
        background: #d1d5db;
    }
</style>
@endpush

@section('content')

<div class="edit-user-container">

    <div class="edit-user-header">
        <h2>Edit Pengguna</h2>
        <p>Perbarui informasi pengguna SIKLASTER PKM Sawah Lega</p>
    </div>

    <div class="edit-user-card">

        <form
            method="POST"
            action="{{ route('users.update', $user) }}"
        >

            @csrf
            @method('PATCH')

            {{-- NAMA --}}
            <div class="form-group">

                <label for="name">
                    Nama
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                >

                @error('name')
                    <div class="error-message">
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
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                >

                @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- ROLE --}}
            <div class="form-group">

                <label for="role">
                    Role Pengguna
                </label>

                <select
                    id="role"
                    name="role"
                    required
                >

                    <option
                        value="user"
                        {{ old('role', $user->role) === 'user' ? 'selected' : '' }}
                    >
                        USER
                    </option>

                    <option
                        value="admin"
                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                    >
                        ADMIN
                    </option>

                </select>

                @error('role')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- PASSWORD --}}
            <div class="form-group">

                <label for="password">
                    Password Baru
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="new-password"
                >

                <div class="form-help">
                    Kosongkan jika password tidak ingin diubah.
                </div>

                @error('password')
                    <div class="error-message">
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
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    autocomplete="new-password"
                >

            </div>


            {{-- BUTTON --}}
            <div class="form-footer">

                <a
                    href="{{ route('users.index') }}"
                    class="btn-cancel"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn-save"
                >
                    💾 Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection