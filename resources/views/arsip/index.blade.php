@extends('layouts.app')

@section('title', 'Arsip Dokumen - SIKLASTER')
@section('page-title', 'Arsip Dokumen')

@section('content')

<div class="arsip-container">

    {{-- =========================
         HEADER
    ========================= --}}

    <div class="arsip-header">

        <div>

            <div class="arsip-badge">
                ARSIP SIKLASTER
            </div>

            <h2>
                Arsip Dokumen Terstruktur
            </h2>

            <p>
                @if(auth()->user()->role === 'admin')
                    Telusuri seluruh dokumen berdasarkan
                    Klaster, Program, Tahun, dan Periode.
                @else
                    Telusuri dokumen Anda berdasarkan
                    Klaster, Program, Tahun, dan Periode.
                @endif
            </p>

        </div>


        <div class="arsip-animation">

            <div class="folder-back"></div>

            <div class="folder-front">

                <div class="folder-document"></div>

            </div>

        </div>

    </div>


    {{-- =========================
         RINGKASAN
    ========================= --}}

    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon blue">
                🗂️
            </div>

            <div>
                <div class="summary-label">
                    Total Klaster
                </div>

                <div class="summary-number">
                    {{ $klasters->count() }}
                </div>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon green">
                📄
            </div>

            <div>
                <div class="summary-label">
                    @if(auth()->user()->role === 'admin')
                        Total Dokumen Arsip
                    @else
                        Dokumen Saya
                    @endif
                </div>

                <div class="summary-number">
                    {{ $jumlahDokumenArsip }}
                </div>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon cyan">
                📅
            </div>

            <div>
                <div class="summary-label">
                    Tahun Tersedia
                </div>

                <div class="summary-number">
                    {{ $jumlahTahun }}
                </div>
            </div>

        </div>

    </div>


    {{-- =========================
         KLASTER
    ========================= --}}

    <div class="arsip-section">

        <div class="section-heading">

            <h3>
                Pilih Klaster
            </h3>

            <p>
                Klik salah satu Klaster untuk melihat Program
                dan arsip dokumen di dalamnya.
            </p>

        </div>


        <div class="klaster-grid">

            @forelse($klasters as $klaster)

                <a
                    href="{{ route('arsip.klaster', $klaster) }}"
                    class="klaster-arsip-card"
                >

                    <div class="klaster-card-top">

                        <div class="klaster-number">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="dokumen-count">

                            {{ $klaster->dokumens_count }}

                            <span>
                                dokumen
                            </span>

                        </div>

                    </div>


                    <div class="folder-icon">
                        📁
                    </div>


                    <div class="klaster-code">
                        {{ $klaster->kode_klaster ?? 'KLASTER' }}
                    </div>


                    <div class="klaster-title">
                        {{ $klaster->nama_klaster }}
                    </div>


                    <div class="klaster-description">

                        @if($klaster->dokumens_count > 0)

                            Tersedia
                            {{ $klaster->dokumens_count }}
                            dokumen yang dapat ditelusuri.

                        @else

                            Belum ada dokumen pada Klaster ini.

                        @endif

                    </div>


                    <div class="klaster-footer">

                        <span>
                            Program → Tahun → Dokumen
                        </span>


                        @if($klaster->dokumens_count > 0)

                            <span class="available">
                                Buka Arsip
                            </span>

                        @else

                            <span class="empty-status">
                                Kosong
                            </span>

                        @endif

                    </div>

                </a>


            @empty

                <div class="empty-arsip">
                    Belum ada Klaster yang tersedia.
                </div>

            @endforelse

        </div>

    </div>

</div>


<style>

/* =========================
   CONTAINER
========================= */

.arsip-container {
    width: 100%;
}


/* =========================
   HEADER
========================= */

.arsip-header {
    position: relative;

    overflow: hidden;

    min-height: 175px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 30px;

    padding: 30px 35px;

    margin-bottom: 24px;

    border-radius: 16px;

    color: white;

    background: linear-gradient(
        120deg,
        #075985 0%,
        #0b8e9e 50%,
        #16a34a 100%
    );

    box-shadow:
        0 10px 28px
        rgba(7,89,133,0.14);
}

.arsip-header::before {
    content: '';

    position: absolute;

    width: 270px;
    height: 270px;

    right: 120px;
    top: -170px;

    border-radius: 50%;

    background:
        rgba(255,255,255,0.07);
}

.arsip-header h2 {
    position: relative;

    margin: 9px 0 7px;

    font-size: 28px;

    z-index: 2;
}

.arsip-header p {
    position: relative;

    margin: 0;

    max-width: 620px;

    font-size: 13px;
    line-height: 1.6;

    color: #e5f8f4;

    z-index: 2;
}

.arsip-badge {
    position: relative;

    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 10px;
    font-weight: bold;

    letter-spacing: 1px;

    background:
        rgba(255,255,255,0.14);

    border:
        1px solid rgba(255,255,255,0.20);

    z-index: 2;
}


/* =========================
   FOLDER ANIMATION
========================= */

.arsip-animation {
    position: relative;

    width: 150px;
    height: 115px;

    flex-shrink: 0;

    z-index: 2;

    animation:
        folderFloat
        2.8s ease-in-out infinite;
}

.folder-back {
    position: absolute;

    width: 105px;
    height: 70px;

    left: 20px;
    top: 26px;

    border-radius: 9px;

    background:
        rgba(255,255,255,0.28);

    transform:
        rotate(-5deg);
}

.folder-front {
    position: absolute;

    width: 115px;
    height: 75px;

    left: 18px;
    top: 36px;

    border-radius: 8px;

    background:
        linear-gradient(
            145deg,
            #ffffff,
            #dff7ef
        );

    box-shadow:
        0 12px 28px
        rgba(0,0,0,0.14);

    overflow: hidden;
}

.folder-front::before {
    content: '';

    position: absolute;

    width: 45px;
    height: 14px;

    left: 0;
    top: -1px;

    border-radius:
        8px 8px 0 0;

    background: #bce9dd;
}

.folder-document {
    position: absolute;

    width: 55px;
    height: 67px;

    left: 30px;
    bottom: 16px;

    border-radius: 5px;

    background: white;

    border:
        1px solid #d5ece8;

    transform:
        rotate(3deg);
}

.folder-document::before,
.folder-document::after {
    content: '';

    position: absolute;

    left: 10px;

    height: 4px;

    border-radius: 10px;

    background: #a7d8df;
}

.folder-document::before {
    top: 17px;
    width: 34px;
}

.folder-document::after {
    top: 29px;
    width: 27px;
}

@keyframes folderFloat {

    0%,
    100% {
        transform:
            translateY(0);
    }

    50% {
        transform:
            translateY(-7px);
    }
}


/* =========================
   SUMMARY
========================= */

.summary-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;

    margin-bottom: 24px;
}

.summary-card {
    background: white;

    border-radius: 13px;

    padding: 19px 21px;

    display: flex;
    align-items: center;

    gap: 14px;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 15px
        rgba(15,23,42,0.05);
}

.summary-icon {
    width: 50px;
    height: 50px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    font-size: 23px;
}

.summary-icon.blue {
    background: #e0f2fe;
}

.summary-icon.green {
    background: #dcfce7;
}

.summary-icon.cyan {
    background: #ccfbf1;
}

.summary-label {
    margin-bottom: 3px;

    font-size: 11px;

    color: #64748b;
}

.summary-number {
    font-size: 26px;

    font-weight: 800;

    color: #0f3d4a;
}


/* =========================
   SECTION
========================= */

.arsip-section {
    padding: 25px;

    border-radius: 14px;

    background: white;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 16px
        rgba(15,23,42,0.05);
}

.section-heading {
    margin-bottom: 22px;
}

.section-heading h3 {
    margin: 0;

    font-size: 19px;

    color: #0f3d4a;
}

.section-heading p {
    margin: 6px 0 0;

    font-size: 12px;

    color: #64748b;
}


/* =========================
   KLASTER
========================= */

.klaster-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 17px;
}

.klaster-arsip-card {
    position: relative;

    overflow: hidden;

    display: block;

    min-height: 240px;

    padding: 20px;

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
        box-shadow 0.2s ease,
        border-color 0.2s ease;
}

.klaster-arsip-card:hover {
    transform:
        translateY(-5px);

    border-color:
        #72cdbd;

    box-shadow:
        0 13px 27px
        rgba(7,89,133,0.10);
}

.klaster-arsip-card::after {
    content: '';

    position: absolute;

    width: 100px;
    height: 100px;

    right: -50px;
    bottom: -50px;

    border-radius: 50%;

    background:
        linear-gradient(
            145deg,
            rgba(11,117,188,0.05),
            rgba(34,197,94,0.08)
        );
}

.klaster-card-top {
    position: relative;

    z-index: 2;

    display: flex;
    align-items: center;
    justify-content: space-between;
}

.klaster-number {
    font-size: 10px;

    font-weight: bold;

    letter-spacing: 1px;

    color: #94a3b8;
}

.dokumen-count {
    padding: 4px 8px;

    border-radius: 20px;

    font-size: 11px;

    font-weight: bold;

    color: #087f8c;

    background: #ecfdf5;
}

.dokumen-count span {
    font-weight: normal;
}

.folder-icon {
    position: relative;

    z-index: 2;

    margin-top: 18px;

    font-size: 34px;

    transition:
        transform 0.2s ease;
}

.klaster-arsip-card:hover
.folder-icon {
    transform:
        translateY(-3px)
        scale(1.05);
}

.klaster-code {
    position: relative;

    z-index: 2;

    margin-top: 12px;

    font-size: 10px;

    font-weight: bold;

    letter-spacing: 0.6px;

    color: #0ea5a4;
}

.klaster-title {
    position: relative;

    z-index: 2;

    margin-top: 5px;

    min-height: 38px;

    font-size: 15px;

    font-weight: 800;

    line-height: 1.35;

    color: #0f3d4a;
}

.klaster-description {
    position: relative;

    z-index: 2;

    margin-top: 9px;

    min-height: 35px;

    font-size: 11px;

    line-height: 1.5;

    color: #64748b;
}

.klaster-footer {
    position: relative;

    z-index: 2;

    margin-top: 15px;

    padding-top: 12px;

    border-top:
        1px solid #e5eeee;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    font-size: 9px;

    color: #94a3b8;
}

.available {
    padding: 4px 7px;

    border-radius: 20px;

    color: #166534;

    background: #dcfce7;

    font-weight: bold;
}

.empty-status {
    padding: 4px 7px;

    border-radius: 20px;

    color: #64748b;

    background: #f1f5f9;

    font-weight: bold;
}

.empty-arsip {
    grid-column:
        1 / -1;

    padding: 40px;

    text-align: center;

    color: #64748b;

    background: #f8fafc;

    border-radius: 10px;
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1050px) {

    .klaster-grid {
        grid-template-columns:
            repeat(2, 1fr);
    }
}


@media (max-width: 800px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }
}


@media (max-width: 600px) {

    .klaster-grid {
        grid-template-columns: 1fr;
    }

    .arsip-header {
        padding: 25px;
    }

    .arsip-animation {
        display: none;
    }
}

</style>

@endsection