@extends('layouts.app')

@section('title', 'Arsip Periode - SIKLASTER')
@section('page-title', 'Arsip Periode')

@section('content')

<div class="periode-page">

    <div class="breadcrumb">

        <a href="{{ route('arsip.index') }}">
            Arsip
        </a>

        <span>&rsaquo;</span>

        <a href="{{ route('arsip.klaster', $program->klaster) }}">
            {{ $program->klaster->nama_klaster }}
        </a>

        <span>&rsaquo;</span>

        <a href="{{ route('arsip.program', $program) }}">
            {{ $program->nama_program }}
        </a>

        <span>&rsaquo;</span>

        <a href="{{ route('arsip.tahun', [
            'program' => $program,
            'tahun' => $tahun
        ]) }}">
            {{ $tahun }}
        </a>

        <span>&rsaquo;</span>

        <strong>
            {{ $periode }}
        </strong>

    </div>


    <div class="periode-header">

        <div>

            <div class="header-badge">
                ARSIP PERIODE
            </div>

            <h2>
                {{ $periode }} {{ $tahun }}
            </h2>

            <p>
                {{ $program->nama_program }}
                &bull;
                {{ $program->klaster->nama_klaster }}
            </p>

        </div>

        <div class="document-animation">
            📂
        </div>

    </div>


    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon blue">
                📄
            </div>

            <div>

                <div class="summary-label">
                    Total Dokumen
                </div>

                <div class="summary-number">
                    {{ $jumlahDokumenPeriode }}
                </div>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon yellow">
                ⏳
            </div>

            <div>

                <div class="summary-label">
                    Menunggu Verifikasi
                </div>

                <div class="summary-number">
                    {{ $jumlahMenunggu }}
                </div>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon green">
                ✓
            </div>

            <div>

                <div class="summary-label">
                    Terverifikasi
                </div>

                <div class="summary-number">
                    {{ $jumlahTerverifikasi }}
                </div>

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon red">
                ✕
            </div>

            <div>

                <div class="summary-label">
                    Ditolak
                </div>

                <div class="summary-number">
                    {{ $jumlahDitolak }}
                </div>

            </div>

        </div>

    </div>


    <div class="dokumen-section">

        <div class="section-header">

            <div>

                <h3>
                    Daftar Dokumen
                </h3>

                <p>
                    Dokumen pada periode {{ $periode }} {{ $tahun }}.
                </p>

            </div>

        </div>


        <div class="table-wrapper">

            <table class="dokumen-table">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama Dokumen</th>

                        @if(auth()->user()->role === 'admin')
                            <th>Pengunggah</th>
                        @endif

                        <th>Jenis Dokumen</th>

                        <th>Status</th>

                        <th>Waktu Upload</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($dokumens as $dokumen)

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

    <div class="dokumen-name">
        {{ $dokumen->nama_dokumen }}
    </div>

    @if($dokumen->nama_file)

        <div class="file-name">
            {{ $dokumen->nama_file }}
        </div>

    @endif

</td>


                            @if(auth()->user()->role === 'admin')

                                <td>

                                    @if($dokumen->user)

                                        <div class="user-name">
                                            {{ $dokumen->user->name }}
                                        </div>

                                        <div class="user-email">
                                            {{ $dokumen->user->email }}
                                        </div>

                                    @else

                                        <span class="muted">
                                            -
                                        </span>

                                    @endif

                                </td>

                            @endif


                            <td>
                                {{ $dokumen->jenisDokumen->nama_jenis ?? '-' }}
                            </td>


                            <td>

                                @if($dokumen->status === 'menunggu_verifikasi')

                                    <span class="status menunggu">
                                        Menunggu Verifikasi
                                    </span>

                                @elseif($dokumen->status === 'terverifikasi')

                                    <span class="status terverifikasi">
                                        Terverifikasi
                                    </span>

                                @elseif($dokumen->status === 'ditolak')

                                    <span class="status ditolak">
                                        Ditolak
                                    </span>

                                @else

                                    <span class="status">
                                        {{ $dokumen->status }}
                                    </span>

                                @endif

                            </td>


                            <td>

                                @if($dokumen->created_at)

                                    <div class="date-main">
                                        {{ $dokumen->created_at->format('d-m-Y') }}
                                    </div>

                                    <div class="date-time">
                                        {{ $dokumen->created_at->format('H:i') }}
                                    </div>

                                @else

                                    -

                                @endif

                            </td>


                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="{{ route('dokumens.show', $dokumen) }}"
                                        class="btn-detail"
                                    >
                                        Detail
                                    </a>


                                    <a
                                        href="{{ url('/dokumens/' . $dokumen->id . '/download') }}"
                                        class="btn-download"
                                    >
                                        Download
                                    </a>


                                    @if(
                                        auth()->user()->role !== 'admin'
                                        &&
                                        $dokumen->user_id === auth()->id()
                                        &&
                                        $dokumen->status === 'ditolak'
                                    )

                                        <a
                                            href="{{ route('dokumens.perbaiki', $dokumen) }}"
                                            class="btn-perbaiki"
                                        >
                                            Perbaiki
                                        </a>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                                class="empty-data"
                            >

                                <div class="empty-icon">
                                    📭
                                </div>

                                <div class="empty-title">
                                    Belum Ada Dokumen
                                </div>

                                <div class="empty-description">
                                    Belum ada dokumen pada periode
                                    {{ $periode }} {{ $tahun }}.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

/* =========================
   CONTAINER
========================= */

.periode-page {
    width: 100%;
}


/* =========================
   BREADCRUMB
========================= */

.breadcrumb {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 8px;

    margin-bottom: 15px;

    font-size: 12px;

    color: #64748b;
}

.breadcrumb a {
    color: #087f8c;

    text-decoration: none;

    font-weight: bold;
}

.breadcrumb a:hover {
    text-decoration: underline;
}


/* =========================
   HEADER
========================= */

.periode-header {
    position: relative;

    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 25px;

    padding: 30px 35px;

    margin-bottom: 22px;

    border-radius: 16px;

    color: white;

    background: linear-gradient(
        120deg,
        #075985 0%,
        #0ea5a4 55%,
        #16a34a 100%
    );

    box-shadow:
        0 10px 28px
        rgba(7,89,133,0.14);
}

.periode-header::before {
    content: '';

    position: absolute;

    width: 260px;
    height: 260px;

    right: 130px;
    top: -170px;

    border-radius: 50%;

    background:
        rgba(255,255,255,0.07);
}

.periode-header > div {
    position: relative;
    z-index: 2;
}

.header-badge {
    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: bold;

    letter-spacing: 1px;

    background:
        rgba(255,255,255,0.15);

    border:
        1px solid rgba(255,255,255,0.20);
}

.periode-header h2 {
    margin: 9px 0 7px;

    font-size: 28px;
}

.periode-header p {
    margin: 0;

    font-size: 13px;

    color: #e5f8f4;
}

.document-animation {
    flex-shrink: 0;

    font-size: 68px;

    animation:
        documentFloat
        2.6s ease-in-out infinite;
}

@keyframes documentFloat {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-7px);
    }
}


/* =========================
   SUMMARY
========================= */

.summary-grid {
    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 15px;

    margin-bottom: 22px;
}

.summary-card {
    display: flex;
    align-items: center;

    gap: 13px;

    padding: 18px;

    border-radius: 12px;

    background: white;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 14px
        rgba(15,23,42,0.04);
}

.summary-icon {
    width: 47px;
    height: 47px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    font-size: 21px;

    font-weight: bold;
}

.summary-icon.blue {
    background: #e0f2fe;
    color: #0369a1;
}

.summary-icon.yellow {
    background: #fef3c7;
    color: #92400e;
}

.summary-icon.green {
    background: #dcfce7;
    color: #166534;
}

.summary-icon.red {
    background: #fee2e2;
    color: #991b1b;
}

.summary-label {
    font-size: 10px;

    line-height: 1.4;

    color: #64748b;
}

.summary-number {
    margin-top: 3px;

    font-size: 25px;

    font-weight: 800;

    color: #0f3d4a;
}


/* =========================
   DOKUMEN SECTION
========================= */

.dokumen-section {
    padding: 25px;

    border-radius: 14px;

    background: white;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 16px
        rgba(15,23,42,0.05);
}

.section-header {
    margin-bottom: 20px;
}

.section-header h3 {
    margin: 0;

    font-size: 19px;

    color: #0f3d4a;
}

.section-header p {
    margin: 6px 0 0;

    font-size: 12px;

    color: #64748b;
}


/* =========================
   TABLE
========================= */

.table-wrapper {
    width: 100%;

    overflow-x: auto;
}

.dokumen-table {
    width: 100%;

    min-width: 950px;

    border-collapse: collapse;
}

.dokumen-table th {
    padding: 12px;

    text-align: left;

    font-size: 10px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.3px;

    color: #64748b;

    background:
        linear-gradient(
            180deg,
            #f8fafc,
            #f1f7f7
        );

    border-bottom:
        1px solid #dcebea;
}

.dokumen-table td {
    padding: 13px 12px;

    vertical-align: top;

    font-size: 12px;

    color: #334155;

    border-bottom:
        1px solid #eef2f2;
}

.dokumen-table tbody tr {
    transition:
        background 0.2s ease;
}

.dokumen-table tbody tr:hover {
    background: #f8fcfb;
}

.dokumen-name {
    font-weight: 700;

    color: #0f3d4a;
}

.file-name {
    margin-top: 4px;

    max-width: 260px;

    overflow: hidden;

    text-overflow: ellipsis;

    white-space: nowrap;

    font-size: 10px;

    color: #94a3b8;
}

.user-name {
    font-weight: 600;

    color: #334155;
}

.user-email {
    margin-top: 3px;

    font-size: 10px;

    color: #94a3b8;
}

.muted {
    color: #94a3b8;
}

.date-main {
    font-weight: 600;
}

.date-time {
    margin-top: 3px;

    font-size: 10px;

    color: #94a3b8;
}


/* =========================
   STATUS
========================= */

.status {
    display: inline-block;

    padding: 5px 9px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: bold;

    white-space: nowrap;
}

.status.menunggu {
    background: #fef3c7;

    color: #92400e;
}

.status.terverifikasi {
    background: #dcfce7;

    color: #166534;
}

.status.ditolak {
    background: #fee2e2;

    color: #991b1b;
}


/* =========================
   ACTION
========================= */

.action-buttons {
    display: flex;
    align-items: center;
    flex-wrap: wrap;

    gap: 5px;
}

.btn-detail,
.btn-download,
.btn-perbaiki {
    display: inline-block;

    padding: 7px 10px;

    border-radius: 6px;

    text-decoration: none;

    font-size: 10px;

    font-weight: bold;

    transition:
        transform 0.15s ease,
        opacity 0.15s ease;
}

.btn-detail:hover,
.btn-download:hover,
.btn-perbaiki:hover {
    transform:
        translateY(-1px);

    opacity: 0.9;
}

.btn-detail {
    color: white;

    background: linear-gradient(
        90deg,
        #075985,
        #0ea5a4
    );
}

.btn-download {
    color: #166534;

    background: #dcfce7;

    border:
        1px solid #bbf7d0;
}

.btn-perbaiki {
    color: #92400e;

    background: #fef3c7;

    border:
        1px solid #fde68a;
}


/* =========================
   EMPTY
========================= */

.empty-data {
    padding: 45px !important;

    text-align: center;
}

.empty-icon {
    font-size: 38px;
}

.empty-title {
    margin-top: 8px;

    font-size: 14px;

    font-weight: 800;

    color: #334155;
}

.empty-description {
    margin-top: 5px;

    font-size: 11px;

    color: #94a3b8;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1000px) {

    .summary-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }
}


@media (max-width: 600px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .periode-header {
        padding: 25px;
    }

    .document-animation {
        display: none;
    }
}

</style>

@endsection