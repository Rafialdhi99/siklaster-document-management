@extends('layouts.app')

@section('page-title', 'Sampah Dokumen')

@push('styles')
<style>
    .trash-page {
        padding-bottom: 30px;
    }

    .trash-header {
        margin-bottom: 24px;
    }

    .trash-header h2 {
        margin: 0 0 6px;
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
    }

    .trash-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .trash-alert {
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 14px;
    }

    .trash-alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }

    .trash-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .trash-info {
        padding: 14px 16px;
        margin-bottom: 20px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: 10px;
        color: #92400e;
        font-size: 14px;
        line-height: 1.6;
    }

    .trash-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }

    .trash-card-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .trash-card-header h3 {
        margin: 0;
        font-size: 17px;
        color: #111827;
    }

    .trash-count {
        background: #f3f4f6;
        color: #374151;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .trash-table-wrapper {
        overflow-x: auto;
    }

    .trash-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px;
    }

    .trash-table th {
        background: #f9fafb;
        color: #4b5563;
        text-align: left;
        padding: 13px 14px;
        font-size: 12px;
        font-weight: 700;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .trash-table td {
        padding: 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #374151;
        vertical-align: top;
    }

    .trash-table tr:last-child td {
        border-bottom: none;
    }

    .document-name {
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .file-name {
        font-size: 12px;
        color: #6b7280;
        word-break: break-word;
    }

    .status-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .status-terverifikasi {
        background: #d1fae5;
        color: #065f46;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .trash-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    .trash-actions form {
        margin: 0;
    }

    .btn-trash {
        border: none;
        border-radius: 8px;
        padding: 8px 11px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        white-space: nowrap;
    }

    .btn-restore {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .btn-restore:hover {
        background: #d1fae5;
    }

    .btn-permanent {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .btn-permanent:hover {
        background: #fee2e2;
    }

    .empty-trash {
        padding: 55px 20px;
        text-align: center;
    }

    .empty-trash-icon {
        font-size: 45px;
        margin-bottom: 12px;
    }

    .empty-trash h3 {
        margin: 0 0 7px;
        color: #374151;
        font-size: 17px;
    }

    .empty-trash p {
        margin: 0;
        color: #9ca3af;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .trash-header h2 {
            font-size: 20px;
        }

        .trash-card-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush


@section('content')

<div class="trash-page">

    <div class="trash-header">
        <h2>🗑️ Sampah Dokumen</h2>

        <p>
            Dokumen yang dihapus sementara tersimpan di halaman ini.
        </p>
    </div>


    @if (session('success'))
        <div class="trash-alert trash-alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if (session('error'))
        <div class="trash-alert trash-alert-error">
            {{ session('error') }}
        </div>
    @endif


    <div class="trash-info">
        <strong>Perhatian:</strong>
        Dokumen di Sampah masih dapat dipulihkan.
        Jika memilih <strong>Hapus Permanen</strong>,
        file asli, riwayat, dan notifikasi terkait dokumen tersebut
        akan dihapus dan tidak dapat dipulihkan kembali.
    </div>


    <div class="trash-card">

        <div class="trash-card-header">

            <h3>Daftar Dokumen Terhapus</h3>

            <span class="trash-count">
                {{ $dokumens->count() }} Dokumen
            </span>

        </div>


        @if ($dokumens->count() > 0)

            <div class="trash-table-wrapper">

                <table class="trash-table">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Dokumen</th>
                            <th>Klaster / Program</th>
                            <th>Periode</th>
                            <th>Pengunggah</th>
                            <th>Status Sebelum Dihapus</th>
                            <th>Waktu Dihapus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>


                    <tbody>

                        @foreach ($dokumens as $dokumen)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

    @if($dokumen->kode_dokumen)

        <div style="
            margin-bottom:6px;
            font-size:11px;
            font-weight:700;
            color:#075985;
            letter-spacing:0.3px;
        ">
            {{ $dokumen->kode_dokumen }}
        </div>

    @endif

    <div class="document-name">
        {{ $dokumen->nama_dokumen }}
    </div>

    <div class="file-name">
        {{ $dokumen->nama_file }}
    </div>

</td>


                                <td>
                                    <strong>
                                        {{ $dokumen->klaster->nama ?? '-' }}
                                    </strong>

                                    <br>

                                    <span class="file-name">
                                        {{ $dokumen->program->nama ?? '-' }}
                                    </span>
                                </td>


                                <td>
                                    {{ $dokumen->periode ?? '-' }}

                                    <br>

                                    <span class="file-name">
                                        {{ $dokumen->tahun ?? '-' }}
                                    </span>
                                </td>


                                <td>
                                    {{ $dokumen->user->name ?? '-' }}

                                    <br>

                                    <span class="file-name">
                                        {{ $dokumen->user->email ?? '-' }}
                                    </span>
                                </td>


                                <td>

                                    @if ($dokumen->status === 'terverifikasi')

                                        <span class="status-badge status-terverifikasi">
                                            Terverifikasi
                                        </span>

                                    @elseif ($dokumen->status === 'ditolak')

                                        <span class="status-badge status-ditolak">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="status-badge status-menunggu">
                                            Menunggu Verifikasi
                                        </span>

                                    @endif

                                </td>


                                <td>
                                    @if ($dokumen->deleted_at)

                                        {{ $dokumen->deleted_at->format('d/m/Y H:i') }}

                                    @else

                                        -

                                    @endif
                                </td>


                                <td>

                                    <div class="trash-actions">

                                        <form
                                            method="POST"
                                            action="{{ route('dokumens.restore', $dokumen->id) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn-trash btn-restore"
                                                onclick="return confirm('Pulihkan dokumen ini?')"
                                            >
                                                ↩ Pulihkan
                                            </button>

                                        </form>


                                        <form
                                            method="POST"
                                            action="{{ route('dokumens.force-delete', $dokumen->id) }}"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-trash btn-permanent"
                                                onclick="return confirm('PERINGATAN: Dokumen akan dihapus permanen dan tidak dapat dipulihkan. Lanjutkan?')"
                                            >
                                                🗑 Hapus Permanen
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-trash">

                <div class="empty-trash-icon">
                    🗑️
                </div>

                <h3>Sampah masih kosong</h3>

                <p>
                    Dokumen yang dihapus akan muncul di halaman ini.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection