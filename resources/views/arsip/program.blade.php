@extends('layouts.app')

@section('title', 'Arsip Program - SIKLASTER')
@section('page-title', 'Arsip Program')

@section('content')

<div class="program-page">

    <div class="breadcrumb">

        <a href="{{ route('arsip.index') }}">
            Arsip
        </a>

        <span>&rsaquo;</span>

        <a href="{{ route('arsip.klaster', $program->klaster) }}">
            {{ $program->klaster->nama_klaster }}
        </a>

        <span>&rsaquo;</span>

        <strong>
            {{ $program->nama_program }}
        </strong>

    </div>


    <div class="program-header">

        <div>

            <div class="header-badge">
                ARSIP PROGRAM
            </div>

            <h2>
                {{ $program->nama_program }}
            </h2>

            <p>
                Pilih Tahun untuk melihat dokumen
                yang tersimpan pada Program ini.
            </p>

        </div>

        <div class="calendar-animation">
            📅
        </div>

    </div>


    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-icon">
                📄
            </div>

            <div>
                <div class="summary-label">
                    Total Dokumen
                </div>

                <div class="summary-number">
                    {{ $jumlahDokumenProgram }}
                </div>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                📅
            </div>

            <div>
                <div class="summary-label">
                    Tahun Tersedia
                </div>

                <div class="summary-number">
                    {{ $jumlahTahunProgram }}
                </div>
            </div>

        </div>


        <div class="summary-card">

            <div class="summary-icon">
                ✅
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

    </div>


    <div class="status-mini-grid">

        <div class="status-mini menunggu">
            <span>Menunggu Verifikasi</span>
            <strong>{{ $jumlahMenunggu }}</strong>
        </div>

        <div class="status-mini terverifikasi">
            <span>Terverifikasi</span>
            <strong>{{ $jumlahTerverifikasi }}</strong>
        </div>

        <div class="status-mini ditolak">
            <span>Ditolak</span>
            <strong>{{ $jumlahDitolak }}</strong>
        </div>

    </div>


    <div class="tahun-section">

        <h3>
            Pilih Tahun
        </h3>

        <p>
            Klik Tahun untuk membuka daftar dokumen.
        </p>


        <div class="tahun-grid">

            @forelse($tahunDokumens as $tahun)

                <a
                    href="{{ route('arsip.tahun', [
                        'program' => $program,
                        'tahun' => $tahun->tahun
                    ]) }}"
                    class="tahun-card"
                >

                    <div class="tahun-icon">
                        📅
                    </div>

                    <div class="tahun-number">
                        {{ $tahun->tahun }}
                    </div>

                    <div class="tahun-count">
                        {{ $tahun->jumlah_dokumen }}
                        dokumen
                    </div>

                    <div class="tahun-footer">
                        Buka Dokumen →
                    </div>

                </a>

            @empty

                <div class="empty-box">
                    Belum ada arsip Tahun pada Program ini.
                </div>

            @endforelse

        </div>

    </div>

</div>


<style>

.program-page {
    width: 100%;
}

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

.program-header {
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

.header-badge {
    display: inline-block;

    padding: 5px 10px;

    border-radius: 20px;

    background:
        rgba(255,255,255,0.15);

    font-size: 10px;

    font-weight: bold;
}

.program-header h2 {
    margin: 9px 0 7px;

    font-size: 27px;
}

.program-header p {
    margin: 0;

    font-size: 13px;

    color: #e5f8f4;
}

.calendar-animation {
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

.summary-grid {
    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 17px;

    margin-bottom: 15px;
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

.status-mini-grid {
    display: grid;

    grid-template-columns:
        repeat(3,1fr);

    gap: 12px;

    margin-bottom: 22px;
}

.status-mini {
    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 12px 15px;

    border-radius: 10px;

    font-size: 11px;
}

.status-mini strong {
    font-size: 17px;
}

.status-mini.menunggu {
    background: #fef3c7;

    color: #92400e;
}

.status-mini.terverifikasi {
    background: #dcfce7;

    color: #166534;
}

.status-mini.ditolak {
    background: #fee2e2;

    color: #991b1b;
}

.tahun-section {
    padding: 25px;

    border-radius: 14px;

    background: white;

    border:
        1px solid #e5eeee;
}

.tahun-section h3 {
    margin: 0;

    font-size: 19px;

    color: #0f3d4a;
}

.tahun-section > p {
    margin:
        6px 0 21px;

    font-size: 12px;

    color: #64748b;
}

.tahun-grid {
    display: grid;

    grid-template-columns:
        repeat(4,1fr);

    gap: 16px;
}

.tahun-card {
    display: block;

    padding: 20px;

    text-align: center;

    text-decoration: none;

    color: inherit;

    border-radius: 13px;

    background: linear-gradient(
        145deg,
        #f5fbff,
        #f1fbf5
    );

    border:
        1px solid #dcebea;

    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        border-color 0.2s ease;
}

.tahun-card:hover {
    transform:
        translateY(-4px);

    border-color:
        #7ccfc0;

    box-shadow:
        0 10px 22px
        rgba(7,89,133,0.08);
}

.tahun-icon {
    font-size: 31px;
}

.tahun-number {
    margin-top: 10px;

    font-size: 27px;

    font-weight: 800;

    color: #075985;
}

.tahun-count {
    margin-top: 5px;

    font-size: 11px;

    color: #64748b;
}

.tahun-footer {
    margin-top: 14px;

    padding-top: 10px;

    border-top:
        1px solid #dcebea;

    font-size: 9px;

    color: #0ea5a4;

    font-weight: bold;
}

.empty-box {
    grid-column: 1 / -1;

    padding: 40px;

    text-align: center;

    border-radius: 10px;

    background: #f8fafc;

    color: #64748b;
}

@media (max-width: 950px) {

    .tahun-grid {
        grid-template-columns:
            repeat(2,1fr);
    }
}

@media (max-width: 700px) {

    .summary-grid,
    .status-mini-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 500px) {

    .tahun-grid {
        grid-template-columns: 1fr;
    }

    .calendar-animation {
        display: none;
    }
}

</style>

@endsection