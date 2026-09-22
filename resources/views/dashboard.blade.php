@extends('layouts.app')

@section('title', 'SIKLASTER')
@section('page-title', 'Dashboard')

@section('content')

@php
    $totalStatus =
        $jumlahMenungguVerifikasi +
        $jumlahTerverifikasi +
        $jumlahDitolak;

    if ($totalStatus > 0) {
        $persenMenunggu =
            round(($jumlahMenungguVerifikasi / $totalStatus) * 100, 1);

        $persenTerverifikasi =
            round(($jumlahTerverifikasi / $totalStatus) * 100, 1);

        $persenDitolak =
            round(($jumlahDitolak / $totalStatus) * 100, 1);
    } else {
        $persenMenunggu = 0;
        $persenTerverifikasi = 0;
        $persenDitolak = 0;
    }

    $batasMenunggu = $persenMenunggu;

    $batasTerverifikasi =
        $persenMenunggu +
        $persenTerverifikasi;

    /*
    |--------------------------------------------------------------------------
    | Nilai Tertinggi Klaster
    |--------------------------------------------------------------------------
    |
    | Dipakai untuk menentukan panjang bar.
    |
    */

    $maksDokumenKlaster =
        $dokumenPerKlaster->max('dokumens_count') ?? 0;
@endphp


<div class="dashboard-container">


    {{-- =========================
         HEADER
    ========================= --}}

    <div class="dashboard-header">

        <div>

            <div class="dashboard-badge">
                SIKLASTER
            </div>

            <h2>

                Selamat Datang, {{ auth()->user()->name }}

            </h2>

            <p>

                Pantau keseluruhan dokumen dan proses verifikasi PKM Sawah Lega.

            </p>

        </div>


        {{-- ANIMASI DOKUMEN --}}

        <div class="header-document-animation">

            <div class="document-main">

                <div class="document-fold"></div>

                <div class="document-line line-1"></div>
                <div class="document-line line-2"></div>
                <div class="document-line line-3"></div>

                <div class="document-check">
                    ✓
                </div>

            </div>

            <div class="document-small document-small-1"></div>

            <div class="document-small document-small-2"></div>

        </div>

    </div>


    {{-- =========================
         STATISTIK
    ========================= --}}

    <div class="stats-grid">

        <div class="stat-card card-blue">

            <div class="stat-icon-wrap blue">
                📂
            </div>

            <div>

                <div class="stat-label">
                    Total Klaster
                </div>

                <div class="stat-number">
                    {{ $jumlahKlaster }}
                </div>

            </div>

        </div>


        <div class="stat-card card-cyan">

            <div class="stat-icon-wrap cyan">
                📋
            </div>

            <div>

                <div class="stat-label">
                    Total Program
                </div>

                <div class="stat-number">
                    {{ $jumlahProgram }}
                </div>

            </div>

        </div>


        <div class="stat-card card-green">

            <div class="stat-icon-wrap green">
                📄
            </div>

            <div>

                <div class="stat-label">

                    Total Dokumen

                </div>

                <div class="stat-number">
                    {{ $jumlahDokumen }}
                </div>

            </div>

        </div>


        <div class="stat-card card-yellow">

            <div class="stat-icon-wrap yellow">
                ⏳
            </div>

            <div>

                <div class="stat-label">
                    Menunggu Verifikasi
                </div>

                <div class="stat-number">
                    {{ $jumlahMenungguVerifikasi }}
                </div>

            </div>

        </div>


        <div class="stat-card card-success">

            <div class="stat-icon-wrap success">
                ✓
            </div>

            <div>

                <div class="stat-label">
                    Terverifikasi
                </div>

                <div class="stat-number">
                    {{ $jumlahTerverifikasi }}
                </div>

            </div>

        </div>


        <div class="stat-card card-red">

            <div class="stat-icon-wrap red">
                ✕
            </div>

            <div>

                <div class="stat-label">
                    Ditolak
                </div>

                <div class="stat-number">
                    {{ $jumlahDitolak }}
                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         GRAFIK STATUS
    ========================= --}}

    <div class="dashboard-section">

        <div class="section-header">

            <div>

                <div class="section-title">
                    Statistik Status Dokumen
                </div>

                <div class="section-subtitle">

                    Komposisi status seluruh dokumen SIKLASTER.

                </div>

            </div>

        </div>


        <div class="chart-area">

            <div class="donut-column">

                <div
                    class="donut-chart"
                    style="
                        background:
                            conic-gradient(
                                #f59e0b 0% {{ $batasMenunggu }}%,
                                #16a34a {{ $batasMenunggu }}% {{ $batasTerverifikasi }}%,
                                #ef4444 {{ $batasTerverifikasi }}% 100%
                            );
                    "
                >

                    <div class="donut-center">

                        <div class="donut-total">
                            {{ $totalStatus }}
                        </div>

                        <div class="donut-label">
                            Dokumen
                        </div>

                    </div>

                </div>

            </div>


            <div class="chart-legend">

                <div class="legend-item">

                    <div class="legend-left">

                        <span class="legend-color yellow"></span>

                        <div>

                            <div class="legend-title">
                                Menunggu Verifikasi
                            </div>

                            <div class="legend-description">
                                Dokumen belum diproses Admin
                            </div>

                        </div>

                    </div>

                    <div class="legend-result">

                        <strong>
                            {{ $jumlahMenungguVerifikasi }}
                        </strong>

                        <span>
                            {{ $persenMenunggu }}%
                        </span>

                    </div>

                </div>


                <div class="legend-item">

                    <div class="legend-left">

                        <span class="legend-color green"></span>

                        <div>

                            <div class="legend-title">
                                Terverifikasi
                            </div>

                            <div class="legend-description">
                                Dokumen telah disetujui
                            </div>

                        </div>

                    </div>

                    <div class="legend-result">

                        <strong>
                            {{ $jumlahTerverifikasi }}
                        </strong>

                        <span>
                            {{ $persenTerverifikasi }}%
                        </span>

                    </div>

                </div>


                <div class="legend-item">

                    <div class="legend-left">

                        <span class="legend-color red"></span>

                        <div>

                            <div class="legend-title">
                                Ditolak
                            </div>

                            <div class="legend-description">
                                Dokumen memerlukan perbaikan
                            </div>

                        </div>

                    </div>

                    <div class="legend-result">

                        <strong>
                            {{ $jumlahDitolak }}
                        </strong>

                        <span>
                            {{ $persenDitolak }}%
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         DISTRIBUSI KLASTER
    ========================= --}}

    <div class="dashboard-section">

        <div class="section-header">

            <div>

                <div class="section-title">
                    Distribusi Dokumen per Klaster
                </div>

                <div class="section-subtitle">

                    Perbandingan jumlah seluruh dokumen pada masing-masing klaster.

                </div>

            </div>

        </div>


        <div class="klaster-chart">

            @foreach($dokumenPerKlaster as $klaster)

                @php
                    if ($maksDokumenKlaster > 0) {
                        $persenBarKlaster =
                            ($klaster->dokumens_count / $maksDokumenKlaster) * 100;
                    } else {
                        $persenBarKlaster = 0;
                    }
                @endphp


                <div class="klaster-bar-row">

                    <div class="klaster-bar-header">

                        <div class="klaster-bar-name">
                            {{ $klaster->nama_klaster }}
                        </div>

                        <div class="klaster-bar-total">
                            {{ $klaster->dokumens_count }} dokumen
                        </div>

                    </div>


                    <div class="klaster-bar-track">

                        <div
                            class="klaster-bar-fill"
                            style="
                                width:
                                {{ $persenBarKlaster }}%;
                            "
                        ></div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>


    {{-- =========================
         RINGKASAN KLASTER
    ========================= --}}

    <div class="dashboard-section">

        <div class="section-header">

            <div>

                <div class="section-title">
                    Ringkasan Klaster
                </div>

                <div class="section-subtitle">
                    Jumlah dokumen pada masing-masing klaster.
                </div>

            </div>

        </div>


        <div class="klaster-grid">

            @foreach($dokumenPerKlaster as $klaster)

                <div class="klaster-card">

                    <div class="klaster-name">
                        {{ $klaster->nama_klaster }}
                    </div>

                    <div class="klaster-count">
                        {{ $klaster->dokumens_count }}
                    </div>

                    <div class="klaster-label">
                        dokumen
                    </div>

                </div>

            @endforeach

        </div>

    </div>

    {{-- =========================
         KEPATUHAN DOKUMEN PER PROGRAM
    ========================= --}}

    <div class="dashboard-section">

        <div class="section-header">

            <div>
                <div class="section-title">
                    Kepatuhan Dokumen per Program
                </div>

                <div class="section-subtitle">
                    Monitoring status dokumen yang telah tercatat pada masing-masing program.
                    Persentase menunjukkan tingkat dokumen yang telah terverifikasi.
                </div>
            </div>

        </div>


        <div class="table-wrapper">

            <table class="dashboard-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Klaster</th>
                        <th>Program</th>
                        <th>Total Dokumen</th>
                        <th>Terverifikasi</th>
                        <th>Menunggu</th>
                        <th>Ditolak</th>
                        <th>Tingkat Verifikasi</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($kepatuhanProgram as $program)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $program->klaster->nama_klaster ?? '-' }}
                            </td>

                            <td>
                                <strong>
                                    {{ $program->nama_program }}
                                </strong>
                            </td>

                            <td>
                                {{ $program->total_dokumen }}
                            </td>

                            <td>
                                <span class="status terverifikasi">
                                    {{ $program->terverifikasi_count }}
                                </span>
                            </td>

                            <td>
                                <span class="status menunggu">
                                    {{ $program->menunggu_count }}
                                </span>
                            </td>

                            <td>
                                <span class="status ditolak">
                                    {{ $program->ditolak_count }}
                                </span>
                            </td>

                            <td>

                                <div class="kepatuhan-result">

                                    <div class="kepatuhan-header">

                                        <strong>
                                            {{ $program->tingkat_verifikasi }}%
                                        </strong>

                                        <span>
                                            {{ $program->terverifikasi_count }}
                                            /
                                            {{ $program->total_dokumen }}
                                        </span>

                                    </div>

                                    <div class="kepatuhan-track">

                                        <div
                                            class="kepatuhan-fill"
                                            style="width: {{ $program->tingkat_verifikasi }}%;"
                                        ></div>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="empty">
                                Belum ada data program.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- =========================
         DOKUMEN TERBARU
    ========================= --}}

    <div class="dashboard-section">

        <div class="section-header">

            <div>

                <div class="section-title">

                    Dokumen Terbaru

                </div>

                <div class="section-subtitle">
                    5 dokumen terakhir yang tercatat pada sistem.
                </div>

            </div>


            <a
                href="{{ url('/dokumens') }}"
                class="btn-semua-dokumen"
            >
                Lihat Semua Dokumen
            </a>

        </div>


        <div class="table-wrapper">

            <table class="dashboard-table">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama Dokumen</th>

                        @if(auth()->user()->role === 'admin')
                            <th>Pengunggah</th>
                        @endif

                        <th>Klaster</th>

                        <th>Program</th>

                        <th>Periode</th>

                        <th>Tahun</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($dokumenTerbaru as $dokumen)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>

                                <strong>
                                    {{ $dokumen->nama_dokumen }}
                                </strong>

                                @if($dokumen->nama_file)

                                    <div class="file-name-small">
                                        {{ $dokumen->nama_file }}
                                    </div>

                                @endif

                            </td>


                            @if(auth()->user()->role === 'admin')

                                <td>

                                    @if($dokumen->user)

                                        <strong>
                                            {{ $dokumen->user->name }}
                                        </strong>

                                        <div class="user-email-small">
                                            {{ $dokumen->user->email }}
                                        </div>

                                    @else

                                        <span class="muted">
                                            Dokumen lama
                                        </span>

                                    @endif

                                </td>

                            @endif


                            <td>
                                {{ $dokumen->klaster->nama_klaster ?? '-' }}
                            </td>


                            <td>
                                {{ $dokumen->program->nama_program ?? '-' }}
                            </td>


                            <td>
                                {{ $dokumen->periode ?? '-' }}
                            </td>


                            <td>
                                {{ $dokumen->tahun ?? '-' }}
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

                                <a
                                    href="{{ route('dokumens.show', $dokumen) }}"
                                    class="btn-detail"
                                >
                                    Detail
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="{{ auth()->user()->role === 'admin' ? 9 : 8 }}"
                                class="empty"
                            >
                                Belum ada dokumen.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

.dashboard-container {
    width: 100%;
}


/* =========================
   HEADER
========================= */

.dashboard-header {
    position: relative;
    overflow: hidden;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 30px;

    background: linear-gradient(
        120deg,
        #075985 0%,
        #0b8e9e 50%,
        #16a34a 100%
    );

    color: white;

    padding: 30px 35px;

    border-radius: 16px;

    margin-bottom: 25px;

    box-shadow:
        0 10px 28px
        rgba(7, 89, 133, 0.15);
}

.dashboard-header::before {
    content: '';

    position: absolute;

    width: 260px;
    height: 260px;

    top: -150px;
    right: 140px;

    border-radius: 50%;

    background: rgba(255,255,255,0.06);
}

.dashboard-header h2 {
    position: relative;

    margin: 8px 0 7px;

    font-size: 27px;

    z-index: 2;
}

.dashboard-header p {
    position: relative;

    margin: 0;

    color: #e5f8f4;

    font-size: 14px;

    z-index: 2;
}

.dashboard-badge {
    position: relative;

    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 10px;
    font-weight: bold;

    letter-spacing: 1px;

    background: rgba(255,255,255,0.15);

    border: 1px solid rgba(255,255,255,0.20);

    z-index: 2;
}


/* =========================
   ANIMASI DOKUMEN
========================= */

.header-document-animation {
    position: relative;

    width: 140px;
    height: 125px;

    flex-shrink: 0;

    z-index: 2;
}

.document-main {
    position: absolute;

    width: 88px;
    height: 108px;

    top: 5px;
    left: 25px;

    border-radius: 10px;

    background: white;

    box-shadow:
        0 12px 30px
        rgba(0,0,0,0.16);

    animation:
        documentFloat
        2.5s ease-in-out infinite;

    overflow: hidden;
}

.document-fold {
    position: absolute;

    top: 0;
    right: 0;

    width: 27px;
    height: 27px;

    background: #dff7ef;

    clip-path: polygon(
        0 0,
        100% 100%,
        0 100%
    );
}

.document-line {
    position: absolute;

    left: 16px;

    height: 5px;

    border-radius: 20px;

    background: #b7dce7;
}

.line-1 {
    top: 35px;
    width: 52px;
}

.line-2 {
    top: 50px;
    width: 42px;
}

.line-3 {
    top: 65px;
    width: 50px;
}

.document-check {
    position: absolute;

    left: 29px;
    bottom: 10px;

    width: 30px;
    height: 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: linear-gradient(
        135deg,
        #0ea5a4,
        #22c55e
    );

    color: white;

    font-size: 18px;
    font-weight: bold;

    animation:
        checkPulse
        1.8s ease-in-out infinite;
}

.document-small {
    position: absolute;

    width: 55px;
    height: 70px;

    border-radius: 8px;

    background: rgba(255,255,255,0.30);

    border: 1px solid rgba(255,255,255,0.30);
}

.document-small-1 {
    left: 5px;
    top: 30px;

    animation:
        documentLeft
        3s ease-in-out infinite;
}

.document-small-2 {
    right: 5px;
    top: 30px;

    animation:
        documentRight
        3s ease-in-out infinite;
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

@keyframes checkPulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.12);
    }
}

@keyframes documentLeft {

    0%,
    100% {
        transform:
            rotate(-12deg)
            translateY(0);
    }

    50% {
        transform:
            rotate(-15deg)
            translateY(5px);
    }
}

@keyframes documentRight {

    0%,
    100% {
        transform:
            rotate(12deg)
            translateY(0);
    }

    50% {
        transform:
            rotate(15deg)
            translateY(-5px);
    }
}


/* =========================
   STATISTIK
========================= */

.stats-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

    margin-bottom: 25px;
}

.stat-card {
    position: relative;

    overflow: hidden;

    background: white;

    border-radius: 14px;

    padding: 21px;

    display: flex;
    align-items: center;

    gap: 15px;

    box-shadow:
        0 4px 16px
        rgba(15,23,42,0.05);

    border: 1px solid #e8efef;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);

    box-shadow:
        0 10px 24px
        rgba(15,23,42,0.08);
}

.stat-card::after {
    content: '';

    position: absolute;

    top: 0;
    left: 0;

    width: 4px;
    height: 100%;
}

.card-blue::after {
    background: #0b75bc;
}

.card-cyan::after {
    background: #0ea5a4;
}

.card-green::after {
    background: #22c55e;
}

.card-yellow::after {
    background: #f59e0b;
}

.card-success::after {
    background: #16a34a;
}

.card-red::after {
    background: #ef4444;
}

.stat-icon-wrap {
    width: 54px;
    height: 54px;

    border-radius: 13px;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-shrink: 0;

    font-size: 25px;
    font-weight: bold;
}

.stat-icon-wrap.blue {
    background: #e0f2fe;
}

.stat-icon-wrap.cyan {
    background: #ccfbf1;
}

.stat-icon-wrap.green {
    background: #dcfce7;
}

.stat-icon-wrap.yellow {
    background: #fef3c7;
}

.stat-icon-wrap.success {
    background: #dcfce7;
    color: #166534;
}

.stat-icon-wrap.red {
    background: #fee2e2;
    color: #b91c1c;
}

.stat-label {
    font-size: 12px;

    color: #64748b;

    margin-bottom: 4px;
}

.stat-number {
    font-size: 29px;

    font-weight: 800;

    color: #0f3d4a;
}


/* =========================
   SECTION
========================= */

.dashboard-section {
    background: white;

    border-radius: 14px;

    padding: 25px;

    margin-bottom: 25px;

    box-shadow:
        0 4px 16px
        rgba(15,23,42,0.05);

    border: 1px solid #e8efef;
}

.section-header {
    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 20px;

    margin-bottom: 20px;
}

.section-title {
    font-size: 18px;

    font-weight: 800;

    color: #0f3d4a;
}

.section-subtitle {
    margin-top: 5px;

    font-size: 12px;

    color: #64748b;
}


/* =========================
   DONUT
========================= */

.chart-area {
    display: grid;

    grid-template-columns:
        300px 1fr;

    gap: 45px;

    align-items: center;

    padding: 15px 10px;
}

.donut-column {
    display: flex;
    justify-content: center;
}

.donut-chart {
    width: 215px;
    height: 215px;

    border-radius: 50%;

    position: relative;

    box-shadow:
        0 10px 25px
        rgba(15,23,42,0.08);

    animation:
        donutAppear
        0.8s ease;
}

.donut-center {
    position: absolute;

    width: 132px;
    height: 132px;

    top: 50%;
    left: 50%;

    transform:
        translate(-50%, -50%);

    border-radius: 50%;

    background: white;

    display: flex;
    align-items: center;
    justify-content: center;

    flex-direction: column;

    box-shadow:
        inset 0 0 0 1px
        #eef2f2;
}

.donut-total {
    font-size: 32px;

    font-weight: 800;

    color: #0f3d4a;
}

.donut-label {
    margin-top: 2px;

    font-size: 11px;

    color: #94a3b8;
}

@keyframes donutAppear {

    from {
        opacity: 0;

        transform:
            rotate(-20deg)
            scale(0.85);
    }

    to {
        opacity: 1;

        transform:
            rotate(0deg)
            scale(1);
    }
}


/* =========================
   LEGEND
========================= */

.chart-legend {
    display: flex;

    flex-direction: column;

    gap: 10px;
}

.legend-item {
    min-height: 70px;

    padding: 13px 15px;

    border-radius: 10px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 20px;

    background: #f8fbfb;

    border: 1px solid #e8efef;
}

.legend-left {
    display: flex;
    align-items: center;

    gap: 12px;
}

.legend-color {
    width: 13px;
    height: 13px;

    flex-shrink: 0;

    border-radius: 50%;
}

.legend-color.yellow {
    background: #f59e0b;
}

.legend-color.green {
    background: #16a34a;
}

.legend-color.red {
    background: #ef4444;
}

.legend-title {
    font-size: 13px;

    font-weight: bold;

    color: #334155;
}

.legend-description {
    margin-top: 3px;

    font-size: 10px;

    color: #94a3b8;
}

.legend-result {
    text-align: right;

    min-width: 70px;
}

.legend-result strong {
    display: block;

    font-size: 18px;

    color: #0f3d4a;
}

.legend-result span {
    font-size: 10px;

    color: #64748b;
}


/* =========================
   BAR KLASTER
========================= */

.klaster-chart {
    display: flex;

    flex-direction: column;

    gap: 18px;
}

.klaster-bar-row {
    width: 100%;
}

.klaster-bar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    margin-bottom: 7px;
}

.klaster-bar-name {
    font-size: 12px;

    font-weight: bold;

    color: #334155;
}

.klaster-bar-total {
    font-size: 11px;

    color: #64748b;

    white-space: nowrap;
}

.klaster-bar-track {
    width: 100%;

    height: 13px;

    border-radius: 999px;

    overflow: hidden;

    background: #e8f2f1;
}

.klaster-bar-fill {
    height: 100%;

    min-width: 0;

    border-radius: 999px;

    background: linear-gradient(
        90deg,
        #075985,
        #0ea5a4,
        #22c55e
    );

    animation:
        barGrow
        0.8s ease;
}

@keyframes barGrow {

    from {
        max-width: 0;
        opacity: 0;
    }

    to {
        max-width: 100%;
        opacity: 1;
    }
}


/* =========================
   KLASTER CARD
========================= */

.klaster-grid {
    display: grid;

    grid-template-columns:
        repeat(5, 1fr);

    gap: 12px;
}

.klaster-card {
    padding: 16px;

    border-radius: 11px;

    background: linear-gradient(
        145deg,
        #f5fbff,
        #f1fbf5
    );

    border: 1px solid #dcebea;

    text-align: center;
}

.klaster-name {
    min-height: 36px;

    font-size: 11px;

    color: #475569;

    line-height: 1.4;
}

.klaster-count {
    margin-top: 9px;

    font-size: 27px;

    font-weight: 800;

    color: #087f8c;
}

.klaster-label {
    margin-top: 2px;

    font-size: 10px;

    color: #94a3b8;
}


/* =========================
   TABLE
========================= */

.table-wrapper {
    overflow-x: auto;
}

.dashboard-table {
    width: 100%;

    min-width: 980px;

    border-collapse: collapse;
}

.dashboard-table th {
    background: linear-gradient(
        180deg,
        #f8fafc,
        #f1f7f7
    );

    text-align: left;

    padding: 12px;

    font-size: 11px;

    color: #64748b;

    text-transform: uppercase;

    border-bottom:
        1px solid #dcebea;
}

.dashboard-table td {
    padding: 13px 12px;

    border-bottom:
        1px solid #eef2f2;

    font-size: 12px;

    vertical-align: top;
}

.dashboard-table tbody tr:hover {
    background: #f8fcfb;
}

.file-name-small,
.user-email-small {
    margin-top: 4px;

    font-size: 10px;

    color: #94a3b8;
}

.muted {
    color: #94a3b8;
}


/* =========================
   TINGKAT VERIFIKASI
========================= */

.kepatuhan-result {
    min-width: 150px;
}

.kepatuhan-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 7px;
}

.kepatuhan-header strong {
    font-size: 12px;
    color: #0f3d4a;
}

.kepatuhan-header span {
    font-size: 10px;
    color: #64748b;
}

.kepatuhan-track {
    width: 100%;
    height: 8px;
    overflow: hidden;
    border-radius: 999px;
    background: #e8f2f1;
}

.kepatuhan-fill {
    height: 100%;
    border-radius: 999px;
    background: linear-gradient(
        90deg,
        #075985,
        #0ea5a4,
        #22c55e
    );
    transition: width 0.3s ease;
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
   BUTTON
========================= */

.btn-detail {
    display: inline-block;

    padding: 7px 11px;

    border-radius: 6px;

    text-decoration: none;

    font-size: 11px;

    font-weight: bold;

    background: linear-gradient(
        90deg,
        #075985,
        #0ea5a4
    );

    color: white;
}

.btn-semua-dokumen {
    display: inline-block;

    padding: 9px 13px;

    border-radius: 7px;

    text-decoration: none;

    font-size: 11px;

    font-weight: bold;

    color: #087f8c;

    background: #ecfdf5;

    border:
        1px solid #bbf7d0;
}

.btn-semua-dokumen:hover {
    background: #dcfce7;
}

.empty {
    text-align: center;

    padding: 35px !important;

    color: #64748b;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1100px) {

    .klaster-grid {
        grid-template-columns:
            repeat(3, 1fr);
    }

    .chart-area {
        grid-template-columns:
            250px 1fr;

        gap: 25px;
    }
}


@media (max-width: 900px) {

    .stats-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .chart-area {
        grid-template-columns: 1fr;
    }
}


@media (max-width: 650px) {

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .klaster-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .dashboard-header {
        align-items: flex-start;
    }

    .header-document-animation {
        width: 100px;

        transform: scale(0.75);

        transform-origin: top right;
    }

    .section-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .klaster-bar-header {
        align-items: flex-start;
    }
}

</style>

@endsection