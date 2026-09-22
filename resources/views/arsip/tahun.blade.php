@extends('layouts.app')

@section('title', 'Arsip Tahun - SIKLASTER')
@section('page-title', 'Arsip Tahun')

@section('content')

<div class="tahun-page">

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

        <strong>
            {{ $tahun }}
        </strong>

    </div>


    <div class="tahun-header">

        <div>

            <div class="header-badge">
                ARSIP TAHUN
            </div>

            <h2>
                {{ $program->nama_program }} - {{ $tahun }}
            </h2>

            <p>
                Pilih periode atau bulan untuk melihat dokumen
                yang tersimpan pada Tahun {{ $tahun }}.
            </p>

        </div>

        <div class="calendar-animation">
            📅
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
                    {{ $jumlahDokumenTahun }}
                </div>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon cyan">
                📆
            </div>

            <div>
                <div class="summary-label">
                    Periode Aktif
                </div>

                <div class="summary-number">
                    {{ $jumlahPeriodeAktif }}
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


    <div class="periode-section">

        <div class="section-header">

            <div>

                <h3>
                    Pilih Periode
                </h3>

                <p>
                    Klik bulan untuk membuka daftar dokumen
                    pada periode tersebut.
                </p>

            </div>

        </div>


        <div class="periode-grid">

            @foreach($periodeDokumens as $item)

                <a
                    href="{{ route('arsip.periode', [
                        'program' => $program,
                        'tahun' => $tahun,
                        'periode' => $item->periode
                    ]) }}"
                    class="periode-card
                        {{ $item->jumlah_dokumen > 0 ? 'aktif' : 'kosong' }}"
                >

                    <div class="periode-top">

                        <div class="periode-icon">
                            📁
                        </div>

                        @if($item->jumlah_dokumen > 0)

                            <span class="periode-status tersedia">
                                Tersedia
                            </span>

                        @else

                            <span class="periode-status belum-ada">
                                Kosong
                            </span>

                        @endif

                    </div>


                    <div class="periode-name">
                        {{ $item->periode }}
                    </div>


                    <div class="periode-count">
                        {{ $item->jumlah_dokumen }}
                    </div>


                    <div class="periode-label">
                        dokumen
                    </div>


                    <div class="periode-footer">

                        @if($item->jumlah_dokumen > 0)

                            Buka Dokumen →

                        @else

                            Belum ada dokumen

                        @endif

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</div>


<style>

/* =========================
   CONTAINER
========================= */

.tahun-page {
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

.tahun-header {
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

.tahun-header::before {
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

.tahun-header > div {
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

.tahun-header h2 {
    margin: 9px 0 7px;

    font-size: 27px;
}

.tahun-header p {
    margin: 0;

    max-width: 650px;

    font-size: 13px;

    line-height: 1.55;

    color: #e5f8f4;
}

.calendar-animation {
    flex-shrink: 0;

    font-size: 70px;

    animation:
        calendarFloat
        2.6s ease-in-out infinite;
}

@keyframes calendarFloat {

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
        repeat(5, 1fr);

    gap: 14px;

    margin-bottom: 22px;
}

.summary-card {
    display: flex;
    align-items: center;

    gap: 12px;

    min-width: 0;

    padding: 17px;

    border-radius: 12px;

    background: white;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 14px
        rgba(15,23,42,0.04);
}

.summary-icon {
    width: 45px;
    height: 45px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 11px;

    font-size: 20px;

    font-weight: bold;
}

.summary-icon.blue {
    background: #e0f2fe;
    color: #0369a1;
}

.summary-icon.cyan {
    background: #ccfbf1;
    color: #0f766e;
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

    line-height: 1.35;

    color: #64748b;
}

.summary-number {
    margin-top: 3px;

    font-size: 24px;

    font-weight: 800;

    color: #0f3d4a;
}


/* =========================
   PERIODE SECTION
========================= */

.periode-section {
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
    margin-bottom: 22px;
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
   PERIODE GRID
========================= */

.periode-grid {
    display: grid;

    grid-template-columns:
        repeat(4, 1fr);

    gap: 16px;
}

.periode-card {
    position: relative;

    overflow: hidden;

    display: block;

    min-height: 190px;

    padding: 18px;

    border-radius: 13px;

    text-decoration: none;

    color: inherit;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f5fbfa
        );

    border:
        1px solid #dcebea;

    transition:
        transform 0.2s ease,
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.periode-card::after {
    content: '';

    position: absolute;

    width: 90px;
    height: 90px;

    right: -45px;
    bottom: -45px;

    border-radius: 50%;

    background:
        rgba(14,165,164,0.05);
}

.periode-card.aktif:hover {
    transform:
        translateY(-4px);

    border-color:
        #7ccfc0;

    box-shadow:
        0 11px 24px
        rgba(7,89,133,0.09);
}

.periode-card.kosong {
    background:
        linear-gradient(
            145deg,
            #ffffff,
            #f8fafc
        );
}

.periode-card.kosong:hover {
    transform:
        translateY(-2px);

    border-color:
        #cbd5e1;
}

.periode-top {
    position: relative;

    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;
}

.periode-icon {
    font-size: 30px;
}

.periode-status {
    padding: 4px 7px;

    border-radius: 20px;

    font-size: 9px;

    font-weight: bold;
}

.periode-status.tersedia {
    color: #166534;

    background: #dcfce7;
}

.periode-status.belum-ada {
    color: #64748b;

    background: #f1f5f9;
}

.periode-name {
    position: relative;

    z-index: 2;

    margin-top: 17px;

    font-size: 15px;

    font-weight: 800;

    color: #0f3d4a;
}

.periode-count {
    position: relative;

    z-index: 2;

    margin-top: 8px;

    font-size: 29px;

    font-weight: 800;

    color: #087f8c;
}

.periode-card.kosong
.periode-count {
    color: #94a3b8;
}

.periode-label {
    position: relative;

    z-index: 2;

    margin-top: 1px;

    font-size: 10px;

    color: #94a3b8;
}

.periode-footer {
    position: relative;

    z-index: 2;

    margin-top: 14px;

    padding-top: 10px;

    border-top:
        1px solid #e5eeee;

    font-size: 9px;

    font-weight: bold;

    color: #0ea5a4;
}

.periode-card.kosong
.periode-footer {
    color: #94a3b8;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1150px) {

    .summary-grid {
        grid-template-columns:
            repeat(3, 1fr);
    }
}


@media (max-width: 1000px) {

    .periode-grid {
        grid-template-columns:
            repeat(3, 1fr);
    }
}


@media (max-width: 800px) {

    .summary-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }

    .periode-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }
}


@media (max-width: 550px) {

    .summary-grid,
    .periode-grid {
        grid-template-columns: 1fr;
    }

    .tahun-header {
        padding: 25px;
    }

    .calendar-animation {
        display: none;
    }
}

</style>

@endsection