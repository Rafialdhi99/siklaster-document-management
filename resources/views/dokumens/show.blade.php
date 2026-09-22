@extends('layouts.app')

@section('title', 'Detail Dokumen - SIKLASTER')
@section('page-title', 'Detail Dokumen')

@push('styles')
<style>
    .detail-container {
        width: 100%;
    }

    .detail-header {
        background: #172033;
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .detail-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
    }

    .detail-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }

    .detail-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .btn-back,
    .btn-download,
    .btn-perbaiki {
        display: inline-block;
        padding: 9px 14px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
    }

    .btn-back {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-back:hover {
        background: #d1d5db;
    }

    .btn-download {
        background: #2563eb;
        color: white;
    }

    .btn-download:hover {
        background: #1d4ed8;
    }

    .btn-perbaiki {
        background: #f59e0b;
        color: white;
    }

    .btn-perbaiki:hover {
        background: #d97706;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .card-title {
        margin: 0 0 20px;
        font-size: 18px;
        color: #172033;
        padding-bottom: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 170px 1fr;
        gap: 12px 20px;
    }

    .info-label {
        font-size: 13px;
        color: #64748b;
        font-weight: bold;
    }

    .info-value {
        font-size: 13px;
        color: #1f2937;
        word-break: break-word;
    }

    .status {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
    }

    .status-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .status-terverifikasi {
        background: #dcfce7;
        color: #166534;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .alasan-box {
        margin-top: 12px;
        padding: 12px 14px;
        background: #fef2f2;
        border-left: 4px solid #dc2626;
        border-radius: 6px;
        color: #991b1b;
        font-size: 12px;
        line-height: 1.5;
    }

    .file-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .file-name {
        padding: 12px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        font-size: 13px;
        word-break: break-word;
    }

    .timeline-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .timeline {
        position: relative;
        margin-top: 10px;
        padding-left: 28px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 4px;
        bottom: 4px;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 24px;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -28px;
        top: 3px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #2563eb;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #bfdbfe;
    }

    .timeline-head {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 5px;
    }

    .timeline-action {
        font-size: 13px;
        font-weight: bold;
        color: #172033;
        text-transform: capitalize;
    }

    .timeline-date {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
    }

    .timeline-user {
        font-size: 12px;
        color: #475569;
        margin-bottom: 5px;
    }

    .timeline-description {
        font-size: 12px;
        line-height: 1.6;
        color: #64748b;
    }

    .status-change {
        margin-top: 7px;
        display: inline-block;
        padding: 5px 8px;
        background: #f8fafc;
        border-radius: 6px;
        font-size: 11px;
        color: #475569;
    }

    .empty-timeline {
        padding: 25px;
        text-align: center;
        color: #64748b;
        background: #f8fafc;
        border-radius: 8px;
        font-size: 13px;
    }

    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 5px;
        }

        .info-value {
            margin-bottom: 12px;
        }
    }
</style>
@endpush

@section('content')

<div class="detail-container">

    <div class="detail-header">
        <h2>{{ $dokumen->nama_dokumen }}</h2>

        <p>
            Informasi lengkap dokumen dan riwayat proses verifikasi.
        </p>
    </div>


    {{-- TOMBOL AKSI --}}

    <div class="detail-actions">

        <a
            href="{{ url('/dokumens') }}"
            class="btn-back"
        >
            &larr; Kembali ke Dokumen
        </a>

        <a
            href="{{ url('/dokumens/' . $dokumen->id . '/download') }}"
            class="btn-download"
        >
            Download Dokumen
        </a>

        @if($dokumen->status === 'ditolak')

            <a
                href="{{ route('dokumens.perbaiki', $dokumen) }}"
                class="btn-perbaiki"
            >
                Perbaiki Dokumen
            </a>

        @endif

    </div>


    {{-- INFORMASI UTAMA --}}

    <div class="detail-grid">

        <div class="card">

            <h3 class="card-title">
                Informasi Dokumen
            </h3>

            <div class="info-grid">

    <div class="info-label">
        Kode SIKLASTER
    </div>

    <div class="info-value">

        @if($dokumen->kode_dokumen)

            <strong style="
                color:#075985;
                letter-spacing:0.3px;
            ">
                {{ $dokumen->kode_dokumen }}
            </strong>

        @else

            <span style="color:#94a3b8;">
                -
            </span>

        @endif

    </div>


    <div class="info-label">
        Nama Dokumen
    </div>

    <div class="info-value">
        {{ $dokumen->nama_dokumen }}
    </div>


                <div class="info-label">
                    Klaster
                </div>

                <div class="info-value">
                    {{ $dokumen->klaster->nama_klaster ?? '-' }}
                </div>


                <div class="info-label">
                    Program
                </div>

                <div class="info-value">
                    {{ $dokumen->program->nama_program ?? '-' }}
                </div>


                <div class="info-label">
                    Jenis Dokumen
                </div>

                <div class="info-value">
                    {{ $dokumen->jenisDokumen->nama_jenis ?? '-' }}
                </div>


                <div class="info-label">
                    Periode
                </div>

                <div class="info-value">
                    {{ $dokumen->periode ?? '-' }}
                </div>


                <div class="info-label">
                    Tahun
                </div>

                <div class="info-value">
                    {{ $dokumen->tahun ?? '-' }}
                </div>


                <div class="info-label">
                    Tanggal Upload
                </div>

                <div class="info-value">
                    {{ $dokumen->created_at?->format('d/m/Y H:i') ?? '-' }}
                </div>


                <div class="info-label">
                    Deskripsi
                </div>

                <div class="info-value">
                    {{ $dokumen->deskripsi ?? '-' }}
                </div>

            </div>

        </div>


        {{-- STATUS & FILE --}}

        <div class="card">

            <h3 class="card-title">
                Status & File
            </h3>

            <div class="file-info">

                <div>

                    <div class="info-label" style="margin-bottom:7px;">
                        Status
                    </div>

                    @if($dokumen->status === 'menunggu_verifikasi')

                        <span class="status status-menunggu">
                            Menunggu Verifikasi
                        </span>

                    @elseif($dokumen->status === 'terverifikasi')

                        <span class="status status-terverifikasi">
                            Terverifikasi
                        </span>

                    @elseif($dokumen->status === 'ditolak')

                        <span class="status status-ditolak">
                            Ditolak
                        </span>

                    @else

                        <span class="status">
                            {{ $dokumen->status }}
                        </span>

                    @endif


                    @if(
                        $dokumen->status === 'ditolak' &&
                        $dokumen->alasan_penolakan
                    )

                        <div class="alasan-box">

                            <strong>
                                Alasan Penolakan:
                            </strong>

                            <br>

                            {{ $dokumen->alasan_penolakan }}

                        </div>

                    @endif

                </div>


                <div>

                    <div class="info-label" style="margin-bottom:7px;">
                        Nama File
                    </div>

                    <div class="file-name">
                        {{ $dokumen->nama_file }}
                    </div>

                </div>


                <div>

                    <div class="info-label" style="margin-bottom:7px;">
                        Tipe File
                    </div>

                    <div class="info-value">
                        {{ $dokumen->file_type ?? '-' }}
                    </div>

                </div>


                <div>

                    <div class="info-label" style="margin-bottom:7px;">
                        Ukuran File
                    </div>

                    <div class="info-value">

                        @if($dokumen->file_size)

                            {{ number_format($dokumen->file_size / 1024, 2) }}
                            KB

                        @else

                            -

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- TIMELINE --}}

    <div class="timeline-card">

        <h3 class="card-title">
            Timeline Riwayat Dokumen
        </h3>

        @if($dokumen->riwayats->count() > 0)

            <div class="timeline">

                @foreach($dokumen->riwayats as $riwayat)

                    <div class="timeline-item">

                        <div class="timeline-dot"></div>

                        <div class="timeline-head">

                            <div class="timeline-action">

                                @if($riwayat->aksi === 'upload')
                                    Dokumen Diupload
                                @elseif($riwayat->aksi === 'ditolak')
                                    Dokumen Ditolak
                                @elseif($riwayat->aksi === 'diperbaiki')
                                    Dokumen Diperbaiki
                                @elseif($riwayat->aksi === 'diverifikasi')
                                    Dokumen Diverifikasi
                                @else
                                    {{ $riwayat->aksi }}
                                @endif

                            </div>

                            <div class="timeline-date">
                                {{ $riwayat->created_at?->format('d/m/Y H:i') ?? '-' }}
                            </div>

                        </div>


                        <div class="timeline-user">

                            Oleh:

                            <strong>
                                {{ $riwayat->user->name ?? 'Pengguna tidak tersedia' }}
                            </strong>

                            @if($riwayat->user)

                                <span style="color:#94a3b8;">
                                    ({{ strtoupper($riwayat->user->role ?? '') }})
                                </span>

                            @endif

                        </div>


                        @if($riwayat->keterangan)

                            <div class="timeline-description">
                                {{ $riwayat->keterangan }}
                            </div>

                        @endif


                        @if(
                            $riwayat->status_sebelum ||
                            $riwayat->status_sesudah
                        )

                            <div class="status-change">

                                {{ $riwayat->status_sebelum ?? 'Awal' }}

                                &rarr;

                                {{ $riwayat->status_sesudah ?? '-' }}

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-timeline">
                Belum ada riwayat proses untuk dokumen ini.
            </div>

        @endif

    </div>

</div>

@endsection