@extends('layouts.app')

@section('title', 'Notifikasi - SIKLASTER')
@section('page-title', 'Notifikasi')

@push('styles')
<style>
    .notifikasi-container {
        width: 100%;
    }

    /* =========================
       HEADER
    ========================= */

    .notifikasi-header {
        background: linear-gradient(135deg, #0f3d4a, #0f766e);
        color: white;
        padding: 26px 30px;
        border-radius: 14px;
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(15, 61, 74, 0.12);
    }

    .notifikasi-header h2 {
        margin: 0 0 6px;
        font-size: 25px;
        font-weight: 800;
    }

    .notifikasi-header p {
        margin: 0;
        color: #d7f3ef;
        font-size: 13px;
        line-height: 1.6;
    }


    /* =========================
       ALERT
    ========================= */

    .alert {
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 18px;
        font-size: 13px;
        font-weight: 600;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-warning {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #bfdbfe;
    }


    /* =========================
       STATISTIK
    ========================= */

    .notifikasi-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    }

    .stat-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 6px;
    }

    .stat-number {
        font-size: 25px;
        font-weight: 800;
        color: #0f3d4a;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .stat-total .stat-icon {
        background: #e0f2fe;
    }

    .stat-belum .stat-icon {
        background: #fef3c7;
    }

    .stat-sudah .stat-icon {
        background: #dcfce7;
    }


    /* =========================
       FILTER + TOOLBAR
    ========================= */

    .notifikasi-control {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: .2s ease;
    }

    .filter-btn:hover {
        background: #eef6f5;
        color: #0f766e;
    }

    .filter-btn.active {
        background: #0f766e;
        color: white;
        border-color: #0f766e;
    }

    .filter-count {
        padding: 2px 6px;
        border-radius: 20px;
        background: rgba(255,255,255,.22);
        font-size: 9px;
    }

    .filter-btn:not(.active) .filter-count {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-semua {
        border: none;
        background: #2563eb;
        color: white;
        padding: 9px 13px;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-semua:hover {
        background: #1d4ed8;
    }


    /* =========================
       LIST NOTIFIKASI
    ========================= */

    .notifikasi-list {
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    .notifikasi-item {
        position: relative;
        background: white;
        border-radius: 12px;
        padding: 18px 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.035);
        transition: .2s ease;
    }

    .notifikasi-item:hover {
        box-shadow: 0 5px 16px rgba(15, 23, 42, 0.07);
    }

    .notifikasi-item.belum-dibaca {
        border-left: 5px solid #2563eb;
        background: #f8fbff;
    }

    .notifikasi-item.sudah-dibaca {
        border-left: 5px solid #cbd5e1;
    }

    .notifikasi-top {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: flex-start;
    }

    .notifikasi-content {
        flex: 1;
        min-width: 0;
    }

    .notifikasi-title-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 6px;
    }

    .notifikasi-judul {
        font-size: 14px;
        font-weight: 800;
        color: #172033;
    }

    .new-indicator {
        display: inline-block;
        padding: 3px 7px;
        border-radius: 20px;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
    }

    .notifikasi-pesan {
        font-size: 12px;
        color: #475569;
        line-height: 1.65;
    }

    .notifikasi-waktu {
        font-size: 10px;
        color: #94a3b8;
        white-space: nowrap;
        text-align: right;
    }

    .notifikasi-relative {
        display: block;
        color: #64748b;
        margin-bottom: 3px;
        font-weight: 600;
    }


    /* =========================
       BADGE JENIS
    ========================= */

    .notifikasi-badge {
        display: inline-block;
        margin-top: 10px;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .badge-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-terverifikasi {
        background: #dcfce7;
        color: #166534;
    }

    .badge-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-default {
        background: #e2e8f0;
        color: #475569;
    }


    /* =========================
       ACTION
    ========================= */

    .notifikasi-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .notifikasi-actions form {
        margin: 0;
    }

    .btn-buka,
    .btn-dibaca {
        display: inline-block;
        border: none;
        padding: 8px 11px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: .2s ease;
    }

    .btn-buka {
        background: #0f3d4a;
        color: white;
    }

    .btn-buka:hover {
        background: #155e75;
    }

    .btn-dibaca {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-dibaca:hover {
        background: #cbd5e1;
    }

    .status-dibaca {
        font-size: 10px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 5px;
    }


    /* =========================
       EMPTY
    ========================= */

    .empty {
        background: white;
        border-radius: 12px;
        padding: 50px 25px;
        text-align: center;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .empty-icon {
        font-size: 35px;
        margin-bottom: 10px;
    }

    .empty-title {
        color: #334155;
        font-size: 14px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .empty-text {
        font-size: 11px;
    }


    /* =========================
       PAGINATION
    ========================= */

    .pagination-wrapper {
        margin-top: 20px;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 800px) {
        .notifikasi-stats {
            grid-template-columns: 1fr;
        }

        .notifikasi-control {
            align-items: stretch;
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }
    }

    @media (max-width: 650px) {
        .notifikasi-header {
            padding: 22px 20px;
        }

        .notifikasi-top {
            flex-direction: column;
            gap: 10px;
        }

        .notifikasi-waktu {
            white-space: normal;
            text-align: left;
        }

        .filter-btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endpush


@section('content')

<div class="notifikasi-container">

    {{-- HEADER --}}
    <div class="notifikasi-header">

        <h2>
            🔔 Notifikasi
        </h2>

        <p>
            Pantau informasi terbaru mengenai dokumen dan proses verifikasi SIKLASTER.
        </p>

    </div>


    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- ALERT WARNING --}}
    @if(session('warning'))

        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>

    @endif


    {{-- ALERT INFO --}}
    @if(session('info'))

        <div class="alert alert-info">
            {{ session('info') }}
        </div>

    @endif


    {{-- STATISTIK --}}
    <div class="notifikasi-stats">

        <div class="stat-card stat-total">

            <div>
                <div class="stat-label">
                    Total Notifikasi
                </div>

                <div class="stat-number">
                    {{ $totalNotifikasi }}
                </div>
            </div>

            <div class="stat-icon">
                🔔
            </div>

        </div>


        <div class="stat-card stat-belum">

            <div>
                <div class="stat-label">
                    Belum Dibaca
                </div>

                <div class="stat-number">
                    {{ $belumDibaca }}
                </div>
            </div>

            <div class="stat-icon">
                📩
            </div>

        </div>


        <div class="stat-card stat-sudah">

            <div>
                <div class="stat-label">
                    Sudah Dibaca
                </div>

                <div class="stat-number">
                    {{ $sudahDibaca }}
                </div>
            </div>

            <div class="stat-icon">
                ✅
            </div>

        </div>

    </div>


    {{-- FILTER + TOOLBAR --}}
    <div class="notifikasi-control">

        <div class="filter-group">

            <a
                href="{{ route('notifikasi.index', ['status' => 'semua']) }}"
                class="filter-btn {{ $status === 'semua' ? 'active' : '' }}"
            >
                Semua

                <span class="filter-count">
                    {{ $totalNotifikasi }}
                </span>
            </a>


            <a
                href="{{ route('notifikasi.index', ['status' => 'belum_dibaca']) }}"
                class="filter-btn {{ $status === 'belum_dibaca' ? 'active' : '' }}"
            >
                Belum Dibaca

                <span class="filter-count">
                    {{ $belumDibaca }}
                </span>
            </a>


            <a
                href="{{ route('notifikasi.index', ['status' => 'sudah_dibaca']) }}"
                class="filter-btn {{ $status === 'sudah_dibaca' ? 'active' : '' }}"
            >
                Sudah Dibaca

                <span class="filter-count">
                    {{ $sudahDibaca }}
                </span>
            </a>

        </div>


        @if($belumDibaca > 0)

            <form
                action="{{ route('notifikasi.semua-dibaca') }}"
                method="POST"
            >

                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="btn-semua"
                    onclick="return confirm('Tandai semua notifikasi sebagai sudah dibaca?')"
                >
                    ✓ Tandai Semua Sudah Dibaca
                </button>

            </form>

        @endif

    </div>


    {{-- DAFTAR NOTIFIKASI --}}
    @if($notifikasis->count() > 0)

        <div class="notifikasi-list">

            @foreach($notifikasis as $notifikasi)

                <div
                    class="
                        notifikasi-item
                        {{ $notifikasi->dibaca ? 'sudah-dibaca' : 'belum-dibaca' }}
                    "
                >

                    <div class="notifikasi-top">

                        <div class="notifikasi-content">

                            <div class="notifikasi-title-row">

                                <div class="notifikasi-judul">
                                    {{ $notifikasi->judul }}
                                </div>


                                @if(!$notifikasi->dibaca)

                                    <span class="new-indicator">
                                        Baru
                                    </span>

                                @endif

                            </div>


                            <div class="notifikasi-pesan">
                                {{ $notifikasi->pesan }}
                            </div>


                            {{-- BADGE JENIS --}}
                            @if($notifikasi->jenis === 'ditolak')

                                <span class="notifikasi-badge badge-ditolak">
                                    Ditolak
                                </span>

                            @elseif($notifikasi->jenis === 'terverifikasi')

                                <span class="notifikasi-badge badge-terverifikasi">
                                    Terverifikasi
                                </span>

                            @elseif($notifikasi->jenis === 'menunggu_verifikasi')

                                <span class="notifikasi-badge badge-menunggu">
                                    Menunggu Verifikasi
                                </span>

                            @elseif($notifikasi->jenis)

                                <span class="notifikasi-badge badge-default">
                                    {{ str_replace('_', ' ', $notifikasi->jenis) }}
                                </span>

                            @endif

                        </div>


                        {{-- WAKTU --}}
                        <div class="notifikasi-waktu">

                            <span class="notifikasi-relative">
                                {{ $notifikasi->created_at?->diffForHumans() }}
                            </span>

                            {{ $notifikasi->created_at?->format('d/m/Y H:i') }}

                        </div>

                    </div>


                    {{-- ACTION --}}
                    <div class="notifikasi-actions">

                        @if($notifikasi->dokumen_id)

                            <a
                                href="{{ route('notifikasi.show', $notifikasi) }}"
                                class="btn-buka"
                            >
                                📄 Buka Dokumen
                            </a>

                        @endif


                        @if(!$notifikasi->dibaca)

                            <form
                                action="{{ route('notifikasi.dibaca', $notifikasi) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn-dibaca"
                                >
                                    ✓ Tandai Dibaca
                                </button>

                            </form>

                        @else

                            <div class="status-dibaca">

                                ✓ Sudah dibaca

                                @if($notifikasi->dibaca_pada)

                                    pada
                                    {{ $notifikasi->dibaca_pada->format('d/m/Y H:i') }}

                                @endif

                            </div>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>


        {{-- PAGINATION --}}
        @if($notifikasis->hasPages())

            <div class="pagination-wrapper">
                {{ $notifikasis->links() }}
            </div>

        @endif


    @else

        <div class="empty">

            <div class="empty-icon">
                🔔
            </div>

            <div class="empty-title">

                @if($status === 'belum_dibaca')

                    Tidak ada notifikasi baru.

                @elseif($status === 'sudah_dibaca')

                    Belum ada notifikasi yang sudah dibaca.

                @else

                    Belum ada notifikasi.

                @endif

            </div>

            <div class="empty-text">
                Notifikasi mengenai aktivitas dan proses verifikasi dokumen akan tampil di halaman ini.
            </div>

        </div>

    @endif

</div>

@endsection