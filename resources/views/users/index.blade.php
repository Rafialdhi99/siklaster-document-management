@extends('layouts.app')

@section('title', 'Manajemen Pengguna - SIKLASTER')
@section('page-title', 'Manajemen Pengguna')

@push('styles')
<style>
    .users-container {
        width: 100%;
    }

    .users-header {
        background: #172033;
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .users-header h2 {
        margin: 0 0 5px;
        font-size: 25px;
    }

    .users-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }

    .users-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table th {
        background: #f1f5f9;
        padding: 13px;
        text-align: left;
        font-size: 13px;
        color: #475569;
    }

    .users-table td {
        padding: 13px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }

    .role-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .role-admin {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .role-user {
        background: #dcfce7;
        color: #166534;
    }

    .empty-users {
        text-align: center;
        padding: 30px;
        color: #64748b;
    }

    .user-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .btn-edit,
    .btn-delete {
        display: inline-block;
        padding: 7px 11px;
        border-radius: 6px;
        text-decoration: none;
        border: none;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-edit {
        background: #2563eb;
        color: white;
    }

    .btn-edit:hover {
        background: #1d4ed8;
    }

    .btn-delete {
        background: #dc2626;
        color: white;
    }

    .btn-delete:hover {
        background: #b91c1c;
    }

    .btn-add {
        display: inline-block;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 7px;
        font-size: 14px;
        font-weight: bold;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #1d4ed8;
    }
</style>
@endpush

@section('content')

<div class="users-container">

    {{-- HEADER --}}
    <div class="users-header">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
        ">

            <div>
                <h2>Manajemen Pengguna</h2>

                <p>
                    Daftar pengguna yang terdaftar pada sistem
                    SIKLASTER PKM Sawah Lega
                </p>
            </div>

            <a
                href="{{ route('users.create') }}"
                class="btn-add"
            >
                + Tambah Pengguna
            </a>

        </div>

    </div>


    {{-- TABEL --}}
    <div class="users-card">

        <table class="users-table">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                @forelse($users as $user)

                    <tr>

                        {{-- NO --}}
                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- NAMA --}}
                        <td>
                            <strong>
                                {{ $user->name }}
                            </strong>
                        </td>


                        {{-- EMAIL --}}
                        <td>
                            {{ $user->email }}
                        </td>


                        {{-- ROLE --}}
                        <td>

                            @if($user->role === 'admin')

                                <span class="role-badge role-admin">
                                    ADMIN
                                </span>

                            @else

                                <span class="role-badge role-user">
                                    {{ strtoupper($user->role ?? 'USER') }}
                                </span>

                            @endif

                        </td>


                        {{-- TERDAFTAR --}}
                        <td>
                            {{ $user->created_at?->format('d/m/Y H:i') }}
                        </td>


                        {{-- AKSI --}}
                        <td>

                            <div class="user-actions">

                                {{-- EDIT --}}
                                <a
                                    href="{{ route('users.edit', $user) }}"
                                    class="btn-edit"
                                >
                                    ✏️ Edit
                                </a>


                                {{-- HAPUS --}}
                                @if($user->id !== auth()->id())

                                    <form
                                        method="POST"
                                        action="{{ route('users.destroy', $user) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');"
                                        style="display:inline;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-delete"
                                        >
                                            🗑️ Hapus
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="empty-users"
                        >
                            Belum ada pengguna.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection