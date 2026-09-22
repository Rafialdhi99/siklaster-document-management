@extends('layouts.app')

@section('title', 'Arsip Klaster - SIKLASTER')
@section('page-title', 'Arsip Klaster')

@section('content')

<div class="arsip-klaster-container">

    <div class="breadcrumb">

        <a href="{{ route('arsip.index') }}">
            Arsip
        </a>

        <span>›</span>

        <strong>
            {{ $klaster->nama_klaster }}
        </strong>

    </div>


    <div class="klaster-header">

        <div>

            <div class="header-badge">
                ARSIP KLASTER
            </div>

            <h2>
                {{ $klaster->nama_klaster }}
            </h2>

            <p>
                Pilih Program untuk melanjutkan penelusuran
                arsip berdasarkan Tahun.
            </p>

        </div>

        <div class="folder-visual">
            📂
        </div>

    </div>


    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-icon">📋</div>

            <div>
                <div class="summary-label">
                    Total Program
                </div>

                <div class="summary-number">
                    {{ $programs->count() }}
                </div>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">📄</div>

            <div>
                <div class="summary-label">
                    Dokumen Klaster
                </div>

                <div class="summary-number">
                    {{ $jumlahDokumenKlaster }}
                </div>
            </div>
        </div>


        <div class="summary-card">
            <div class="summary-icon">📅</div>

            <div>
                <div class="summary-label">
                    Tahun Tersedia
                </div>

                <div class="summary-number">
                    {{ $jumlahTahunKlaster }}
                </div>
            </div>
        </div>

    </div>


    <div class="program-section">

        <h3>
            Program dalam Klaster
        </h3>

        <p class="section-description">
            Klik Program untuk melihat pilihan Tahun.
        </p>


        <div class="program-grid">

            @forelse($programs as $program)

                <a
                    href="{{ route('arsip.program', $program) }}"
                    class="program-card"
                >

                    <div class="program-top">

                        <span class="program-number">
                            PROGRAM
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>

                        <span class="program-count">
                            {{ $program->dokumens_count }}
                        </span>

                    </div>


                    <div class="program-folder">
                        📁
                    </div>


                    <div class="program-name">
                        {{ $program->nama_program }}
                    </div>


                    <div class="program-description">

                        @if($program->dokumens_count > 0)

                            Tersedia
                            {{ $program->dokumens_count }}
                            dokumen.

                        @else

                            Belum ada dokumen.

                        @endif

                    </div>


                    <div class="program-footer">

                        <span>
                            Tahun → Dokumen
                        </span>

                        @if($program->dokumens_count > 0)

                            <span class="available">
                                Buka
                            </span>

                        @else

                            <span class="empty-status">
                                Kosong
                            </span>

                        @endif

                    </div>

                </a>


            @empty

                <div class="empty-box">
                    Belum ada Program.
                </div>

            @endforelse

        </div>

    </div>

</div>


<style>

.arsip-klaster-container {
    width: 100%;
}

.breadcrumb {
    display: flex;
    align-items: center;

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

.klaster-header {
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
        #075985,
        #0ea5a4,
        #16a34a
    );

    box-shadow:
        0 10px 28px
        rgba(7,89,133,0.14);
}

.klaster-header h2 {
    margin: 9px 0 7px;

    font-size: 27px;
}

.klaster-header p {
    margin: 0;

    font-size: 13px;

    color: #e5f8f4;
}

.header-badge {
    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 10px;

    font-weight: bold;

    background:
        rgba(255,255,255,0.15);

    border:
        1px solid rgba(255,255,255,0.20);
}

.folder-visual {
    font-size: 72px;

    animation:
        folderFloat
        2.7s ease-in-out infinite;
}

@keyframes folderFloat {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-7px);
    }
}

.summary-grid {
    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 17px;

    margin-bottom: 22px;
}

.summary-card {
    display: flex;
    align-items: center;

    gap: 14px;

    padding: 19px;

    border-radius: 13px;

    background: white;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 14px
        rgba(15,23,42,0.05);
}

.summary-icon {
    width: 50px;
    height: 50px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #ecfdf5;

    font-size: 23px;
}

.summary-label {
    font-size: 11px;

    color: #64748b;
}

.summary-number {
    margin-top: 3px;

    font-size: 26px;

    font-weight: 800;

    color: #0f3d4a;
}

.program-section {
    padding: 25px;

    border-radius: 14px;

    background: white;

    border:
        1px solid #e5eeee;

    box-shadow:
        0 4px 16px
        rgba(15,23,42,0.05);
}

.program-section h3 {
    margin: 0;

    font-size: 19px;

    color: #0f3d4a;
}

.section-description {
    margin:
        6px 0 21px;

    font-size: 12px;

    color: #64748b;
}

.program-grid {
    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 17px;
}

.program-card {
    display: block;

    min-height: 215px;

    padding: 19px;

    border-radius: 13px;

    text-decoration: none;

    color: inherit;

    background: linear-gradient(
        145deg,
        #ffffff,
        #f5fbfa
    );

    border:
        1px solid #dcebea;

    transition: 0.2s ease;
}

.program-card:hover {
    transform:
        translateY(-4px);

    border-color:
        #7ccfc0;

    box-shadow:
        0 11px 23px
        rgba(7,89,133,0.09);
}

.program-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.program-number {
    font-size: 9px;

    font-weight: bold;

    color: #0ea5a4;
}

.program-count {
    min-width: 29px;
    height: 29px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 20px;

    background: #ecfdf5;

    color: #087f8c;

    font-size: 11px;

    font-weight: bold;
}

.program-folder {
    margin-top: 15px;

    font-size: 32px;
}

.program-name {
    margin-top: 9px;

    min-height: 38px;

    font-size: 14px;

    font-weight: 800;

    line-height: 1.4;

    color: #0f3d4a;
}

.program-description {
    margin-top: 8px;

    min-height: 34px;

    font-size: 11px;

    color: #64748b;
}

.program-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;

    margin-top: 13px;

    padding-top: 11px;

    border-top:
        1px solid #e5eeee;

    font-size: 9px;

    color: #94a3b8;
}

.available {
    padding: 4px 7px;

    border-radius: 20px;

    background: #dcfce7;

    color: #166534;

    font-weight: bold;
}

.empty-status {
    padding: 4px 7px;

    border-radius: 20px;

    background: #f1f5f9;

    color: #64748b;

    font-weight: bold;
}

.empty-box {
    grid-column: 1 / -1;

    padding: 40px;

    text-align: center;

    background: #f8fafc;

    color: #64748b;

    border-radius: 10px;
}

@media (max-width: 1000px) {

    .program-grid {
        grid-template-columns:
            repeat(2,1fr);
    }
}

@media (max-width: 750px) {

    .summary-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {

    .program-grid {
        grid-template-columns: 1fr;
    }

    .folder-visual {
        display: none;
    }
}

</style>

@endsection