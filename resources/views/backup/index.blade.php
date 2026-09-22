@extends('layouts.app')

@section('title', 'Backup Database - SIKLASTER')
@section('page-title', 'Backup Database')

@section('content')

<div class="backup-page">

    {{-- HEADER --}}
    <div class="backup-header">

        <div>
            <div class="backup-badge">
                ADMINISTRATOR
            </div>

            <h2>
                Backup Database SIKLASTER
            </h2>

            <p>
                Buat, simpan, unduh, dan kelola cadangan database
                SIKLASTER untuk menjaga keamanan data aplikasi.
            </p>
        </div>

        <div class="backup-visual">
            💾
        </div>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert success">
            ✓ {{ session('success') }}
        </div>

    @endif


    {{-- ALERT ERROR --}}
    @if(session('error'))

        <div class="alert error">
            ⚠ {{ session('error') }}
        </div>

    @endif


    {{-- RINGKASAN --}}
    <div class="summary-grid">

        <div class="summary-card">

            <div>
                <span class="summary-label">
                    Database
                </span>

                <strong class="summary-value">
                    {{ config('database.connections.mysql.database') }}
                </strong>
            </div>

            <div class="summary-icon">
                🗄️
            </div>

        </div>


        <div class="summary-card">

            <div>
                <span class="summary-label">
                    Total Backup
                </span>

                <strong class="summary-value">
                    {{ $backups->count() }}
                </strong>
            </div>

            <div class="summary-icon">
                📦
            </div>

        </div>


        <div class="summary-card">

            <div>
                <span class="summary-label">
                    Format
                </span>

                <strong class="summary-value">
                    SQL
                </strong>
            </div>

            <div class="summary-icon">
                📄
            </div>

        </div>

    </div>


    {{-- BUAT BACKUP --}}
    <div class="create-card">

        <div class="create-content">

            <div class="create-icon">
                💾
            </div>

            <div>

                <h3>
                    Buat Backup Baru
                </h3>

                <p>
                    Sistem akan membuat salinan database SIKLASTER
                    dan menyimpannya di penyimpanan private aplikasi.
                    File dapat diunduh kembali melalui daftar backup.
                </p>

            </div>

        </div>


        <form
            action="{{ route('backup.store') }}"
            method="POST"
            onsubmit="return mulaiBackup(this)"
        >

            @csrf

            <button
                type="submit"
                class="btn-create"
                id="backupButton"
            >
                <span id="backupButtonText">
                    + Buat Backup Sekarang
                </span>
            </button>

        </form>

    </div>


    {{-- INFORMASI KEAMANAN --}}
    <div class="security-card">

        <div class="security-icon">
            🔒
        </div>

        <div>

            <strong>
                Penyimpanan Private
            </strong>

            <p>
                File backup disimpan di folder private aplikasi dan
                halaman ini hanya dapat diakses oleh Administrator.
                Simpan salinan backup pada perangkat atau media
                penyimpanan administrasi yang aman.
            </p>

        </div>

    </div>


    {{-- RIWAYAT BACKUP --}}
    <div class="history-card">

        <div class="history-header">

            <div>

                <h3>
                    Riwayat Backup
                </h3>

                <p>
                    Daftar file backup database yang tersimpan.
                </p>

            </div>

            <span class="history-count">
                {{ $backups->count() }} File
            </span>

        </div>


        @if($backups->count() > 0)

            <div class="table-wrapper">

                <table class="backup-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Tanggal Backup</th>
                            <th>Ukuran</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($backups as $backup)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    <div class="file-info">

                                        <div class="file-icon">
                                            SQL
                                        </div>

                                        <div>

                                            <strong>
                                                {{ $backup['nama'] }}
                                            </strong>

                                            <span>
                                                Database Backup
                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <td>

                                    <div class="date-info">

                                        <strong>
                                            {{ date(
                                                'd/m/Y',
                                                $backup['dibuat_pada']
                                            ) }}
                                        </strong>

                                        <span>
                                            {{ date(
                                                'H:i:s',
                                                $backup['dibuat_pada']
                                            ) }}
                                        </span>

                                    </div>

                                </td>


                                <td>

                                    @php

                                        $size = $backup['ukuran'];

                                        if ($size >= 1073741824) {

                                            $formattedSize =
                                                number_format(
                                                    $size / 1073741824,
                                                    2
                                                ) . ' GB';

                                        } elseif ($size >= 1048576) {

                                            $formattedSize =
                                                number_format(
                                                    $size / 1048576,
                                                    2
                                                ) . ' MB';

                                        } elseif ($size >= 1024) {

                                            $formattedSize =
                                                number_format(
                                                    $size / 1024,
                                                    2
                                                ) . ' KB';

                                        } else {

                                            $formattedSize =
                                                $size . ' Bytes';
                                        }

                                    @endphp

                                    <span class="size-badge">
                                        {{ $formattedSize }}
                                    </span>

                                </td>


                                <td>

                                    <div class="action-group">

                                        <a
                                            href="{{ route(
                                                'backup.download',
                                                ['file' => $backup['nama']]
                                            ) }}"
                                            class="btn-download"
                                            title="Download Backup"
                                        >
                                            ↓ Download
                                        </a>


                                        <form
                                            action="{{ route(
                                                'backup.destroy',
                                                ['file' => $backup['nama']]
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm(
                                                'Yakin ingin menghapus backup {{ $backup['nama'] }}? File yang sudah dihapus tidak dapat dikembalikan.'
                                            )"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn-delete"
                                                title="Hapus Backup"
                                            >
                                                🗑 Hapus
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

            <div class="empty-backup">

                <div class="empty-icon">
                    📦
                </div>

                <h4>
                    Belum Ada Backup
                </h4>

                <p>
                    Belum ada file backup database yang tersimpan.
                    Klik tombol "Buat Backup Sekarang" untuk membuat
                    backup pertama.
                </p>

            </div>

        @endif

    </div>


    {{-- PERINGATAN --}}
    <div class="warning-card">

        <div class="warning-icon">
            ⚠️
        </div>

        <div>

            <h3>
                Penting
            </h3>

            <p>
                Lakukan backup sebelum update aplikasi, perubahan
                struktur database, migration penting, atau deployment
                ke server/hosting.
            </p>

            <p>
                File backup berisi data aplikasi. Jangan membagikan
                file SQL kepada pihak yang tidak berkepentingan.
            </p>

        </div>

    </div>

</div>


<style>

.backup-page {
    width: 100%;
}


/* =========================
   HEADER
========================= */

.backup-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 25px;

    padding: 30px 35px;

    margin-bottom: 20px;

    border-radius: 16px;

    color: white;

    background: linear-gradient(
        120deg,
        #075985,
        #0f766e,
        #16a34a
    );

    box-shadow:
        0 10px 28px
        rgba(7, 89, 133, 0.14);
}

.backup-badge {
    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    background:
        rgba(255,255,255,0.15);

    font-size: 9px;

    font-weight: 800;

    letter-spacing: 1px;
}

.backup-header h2 {
    margin: 9px 0 7px;

    font-size: 27px;
}

.backup-header p {
    margin: 0;

    max-width: 650px;

    font-size: 13px;

    line-height: 1.6;

    color: #e5f8f4;
}

.backup-visual {
    font-size: 68px;
}


/* =========================
   ALERT
========================= */

.alert {
    margin-bottom: 18px;

    padding: 13px 16px;

    border-radius: 9px;

    font-size: 12px;

    font-weight: 600;
}

.alert.success {
    background: #dcfce7;

    color: #166534;

    border: 1px solid #bbf7d0;
}

.alert.error {
    background: #fee2e2;

    color: #991b1b;

    border: 1px solid #fecaca;
}


/* =========================
   SUMMARY
========================= */

.summary-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 14px;

    margin-bottom: 18px;
}

.summary-card {
    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    padding: 18px 20px;

    background: white;

    border:
        1px solid #e2e8f0;

    border-radius: 12px;

    box-shadow:
        0 3px 12px
        rgba(15, 23, 42, 0.04);
}

.summary-label {
    display: block;

    margin-bottom: 5px;

    color: #94a3b8;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .5px;
}

.summary-value {
    display: block;

    color: #0f3d4a;

    font-size: 18px;
}

.summary-icon {
    display: flex;

    align-items: center;

    justify-content: center;

    width: 42px;

    height: 42px;

    border-radius: 10px;

    background: #ecfdf5;

    font-size: 20px;
}


/* =========================
   CREATE BACKUP
========================= */

.create-card {
    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 25px;

    padding: 22px 24px;

    margin-bottom: 15px;

    background: white;

    border:
        1px solid #e2e8f0;

    border-radius: 13px;

    box-shadow:
        0 3px 12px
        rgba(15, 23, 42, 0.04);
}

.create-content {
    display: flex;

    align-items: center;

    gap: 15px;
}

.create-icon {
    display: flex;

    align-items: center;

    justify-content: center;

    min-width: 48px;

    height: 48px;

    border-radius: 12px;

    background: #ecfdf5;

    font-size: 24px;
}

.create-card h3 {
    margin: 0 0 5px;

    color: #0f3d4a;

    font-size: 15px;
}

.create-card p {
    margin: 0;

    max-width: 650px;

    color: #64748b;

    font-size: 11px;

    line-height: 1.6;
}

.btn-create {
    border: none;

    white-space: nowrap;

    padding: 11px 17px;

    border-radius: 8px;

    color: white;

    font-size: 11px;

    font-weight: 800;

    cursor: pointer;

    background: linear-gradient(
        90deg,
        #075985,
        #0f766e,
        #16a34a
    );

    transition: .2s ease;
}

.btn-create:hover {
    transform: translateY(-1px);

    box-shadow:
        0 5px 12px
        rgba(15, 118, 110, .2);
}

.btn-create:disabled {
    opacity: .65;

    cursor: wait;

    transform: none;
}


/* =========================
   SECURITY
========================= */

.security-card {
    display: flex;

    align-items: flex-start;

    gap: 12px;

    padding: 14px 17px;

    margin-bottom: 18px;

    border-radius: 10px;

    background: #eff6ff;

    border:
        1px solid #dbeafe;
}

.security-icon {
    font-size: 20px;
}

.security-card strong {
    display: block;

    margin-bottom: 3px;

    color: #1e3a8a;

    font-size: 11px;
}

.security-card p {
    margin: 0;

    color: #475569;

    font-size: 10px;

    line-height: 1.6;
}


/* =========================
   HISTORY
========================= */

.history-card {
    overflow: hidden;

    margin-bottom: 18px;

    background: white;

    border:
        1px solid #e2e8f0;

    border-radius: 13px;

    box-shadow:
        0 3px 12px
        rgba(15, 23, 42, 0.04);
}

.history-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding: 18px 20px;

    border-bottom:
        1px solid #e2e8f0;
}

.history-header h3 {
    margin: 0 0 4px;

    color: #0f3d4a;

    font-size: 15px;
}

.history-header p {
    margin: 0;

    color: #94a3b8;

    font-size: 10px;
}

.history-count {
    padding: 5px 9px;

    border-radius: 20px;

    background: #ecfdf5;

    color: #166534;

    font-size: 9px;

    font-weight: 800;
}


/* =========================
   TABLE
========================= */

.table-wrapper {
    width: 100%;

    overflow-x: auto;
}

.backup-table {
    width: 100%;

    border-collapse: collapse;
}

.backup-table th {
    padding: 11px 14px;

    text-align: left;

    background: #f8fafc;

    color: #64748b;

    font-size: 9px;

    font-weight: 800;

    text-transform: uppercase;

    letter-spacing: .4px;

    border-bottom:
        1px solid #e2e8f0;
}

.backup-table td {
    padding: 13px 14px;

    color: #475569;

    font-size: 10px;

    border-bottom:
        1px solid #f1f5f9;

    vertical-align: middle;
}

.backup-table tbody tr:hover {
    background: #fafdfc;
}

.backup-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================
   FILE
========================= */

.file-info {
    display: flex;

    align-items: center;

    gap: 10px;
}

.file-icon {
    display: flex;

    align-items: center;

    justify-content: center;

    min-width: 36px;

    height: 36px;

    border-radius: 8px;

    background: #fee2e2;

    color: #991b1b;

    font-size: 9px;

    font-weight: 900;
}

.file-info strong {
    display: block;

    color: #334155;

    font-size: 10px;

    word-break: break-all;
}

.file-info span {
    display: block;

    margin-top: 2px;

    color: #94a3b8;

    font-size: 9px;
}

.date-info strong {
    display: block;

    color: #334155;

    font-size: 10px;
}

.date-info span {
    display: block;

    margin-top: 2px;

    color: #94a3b8;

    font-size: 9px;
}

.size-badge {
    display: inline-block;

    padding: 4px 8px;

    border-radius: 20px;

    background: #f1f5f9;

    color: #475569;

    font-size: 9px;

    font-weight: 700;
}


/* =========================
   ACTION
========================= */

.action-group {
    display: flex;

    gap: 6px;

    align-items: center;

    flex-wrap: wrap;
}

.action-group form {
    margin: 0;
}

.btn-download,
.btn-delete {
    display: inline-block;

    border: none;

    padding: 7px 9px;

    border-radius: 6px;

    font-size: 9px;

    font-weight: 700;

    cursor: pointer;

    text-decoration: none;
}

.btn-download {
    background: #0f766e;

    color: white;
}

.btn-download:hover {
    background: #115e59;
}

.btn-delete {
    background: #fee2e2;

    color: #991b1b;
}

.btn-delete:hover {
    background: #fecaca;
}


/* =========================
   EMPTY
========================= */

.empty-backup {
    padding: 45px 25px;

    text-align: center;
}

.empty-icon {
    margin-bottom: 8px;

    font-size: 35px;
}

.empty-backup h4 {
    margin: 0 0 5px;

    color: #334155;

    font-size: 13px;
}

.empty-backup p {
    max-width: 500px;

    margin: 0 auto;

    color: #94a3b8;

    font-size: 10px;

    line-height: 1.6;
}


/* =========================
   WARNING
========================= */

.warning-card {
    display: flex;

    gap: 14px;

    padding: 18px 20px;

    border-radius: 12px;

    background:
        linear-gradient(
            145deg,
            #fffdf5,
            #ffffff
        );

    border:
        1px solid #fde68a;
}

.warning-icon {
    font-size: 25px;
}

.warning-card h3 {
    margin: 0 0 5px;

    color: #92400e;

    font-size: 13px;
}

.warning-card p {
    margin: 3px 0;

    color: #64748b;

    font-size: 10px;

    line-height: 1.6;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 850px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .create-card {
        flex-direction: column;

        align-items: stretch;
    }

    .btn-create {
        width: 100%;
    }

}

@media (max-width: 600px) {

    .backup-header {
        padding: 24px 20px;
    }

    .backup-visual {
        display: none;
    }

    .backup-header h2 {
        font-size: 22px;
    }

    .create-content {
        align-items: flex-start;
    }

}

</style>


<script>

function mulaiBackup(form)
{
    const button =
        document.getElementById('backupButton');

    const text =
        document.getElementById('backupButtonText');

    button.disabled = true;

    text.innerText =
        'Membuat Backup...';

    return true;
}

</script>

@endsection