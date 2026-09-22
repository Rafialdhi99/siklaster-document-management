@extends('layouts.app')

@section('title', 'Riwayat Verifikasi - SIKLASTER')
@section('page-title', 'Riwayat Verifikasi')

@push('styles')

<style>

    .riwayat-container {
        width: 100%;
    }

    .riwayat-header {
        background: #172033;
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .riwayat-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
    }

    .riwayat-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }


    /* =========================
       TOMBOL KEMBALI
    ========================= */

    .riwayat-actions {
        margin-bottom: 20px;
    }

    .btn-kembali {
        display: inline-block;
        padding: 9px 14px;
        background: #e5e7eb;
        color: #374151;
        text-decoration: none;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
    }

    .btn-kembali:hover {
        background: #d1d5db;
    }


    /* =========================
       FILTER
    ========================= */

    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .filter-title {
        font-size: 14px;
        font-weight: bold;
        color: #374151;
        margin-bottom: 15px;
    }

    .filter-form {
        display: grid;

        grid-template-columns:
            minmax(220px, 2fr)
            minmax(160px, 1fr)
            minmax(180px, 1fr)
            minmax(120px, 1fr)
            auto
            auto;

        gap: 10px;

        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .filter-group label {
        font-size: 11px;
        font-weight: bold;
        color: #64748b;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        height: 40px;

        padding: 0 10px;

        border: 1px solid #d1d5db;
        border-radius: 7px;

        background: white;

        font-size: 13px;
        color: #374151;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: #2563eb;

        box-shadow:
            0 0 0 3px rgba(37,99,235,0.08);
    }

    .btn-filter,
    .btn-reset {
        height: 40px;

        padding: 0 16px;

        border-radius: 7px;

        border: none;

        font-size: 12px;
        font-weight: bold;

        cursor: pointer;

        white-space: nowrap;
    }

    .btn-filter {
        background: #2563eb;
        color: white;
    }

    .btn-filter:hover {
        background: #1d4ed8;
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        background: #e5e7eb;
        color: #374151;

        text-decoration: none;
    }

    .btn-reset:hover {
        background: #d1d5db;
    }


    /* =========================
       INFORMASI HASIL
    ========================= */

    .hasil-info {
        display: flex;
        justify-content: space-between;
        align-items: center;

        margin-bottom: 15px;

        font-size: 12px;
        color: #64748b;
    }

    .hasil-info strong {
        color: #1f2937;
    }


    /* =========================
       CARD TABEL
    ========================= */

    .riwayat-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .riwayat-table {
        width: 100%;
        min-width: 1450px;
        border-collapse: collapse;
    }

    .riwayat-table th {
        background: #f1f5f9;

        padding: 13px;

        text-align: left;

        font-size: 12px;
        color: #475569;

        text-transform: uppercase;

        white-space: nowrap;
    }

    .riwayat-table td {
        padding: 13px;

        border-bottom: 1px solid #e5e7eb;

        font-size: 13px;

        vertical-align: top;
    }

    .riwayat-table tbody tr:hover {
        background: #f8fafc;
    }


    /* =========================
       PENGUNGGAH
    ========================= */

    .pengunggah-name {
        font-weight: bold;
        color: #1f2937;
    }

    .pengunggah-email {
        margin-top: 3px;

        font-size: 11px;

        color: #64748b;
    }


    /* =========================
       STATUS
    ========================= */

    .status {
        display: inline-block;

        padding: 6px 10px;

        border-radius: 20px;

        font-size: 11px;

        font-weight: bold;

        white-space: nowrap;
    }

    .status-terverifikasi {
        background: #dcfce7;
        color: #166534;
    }

    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .alasan {
        margin-top: 6px;

        max-width: 240px;

        font-size: 11px;

        line-height: 1.5;

        color: #991b1b;
    }


    /* =========================
       FILE
    ========================= */

    .file-link {
        display: inline-block;

        padding: 7px 11px;

        background: #2563eb;

        color: white;

        text-decoration: none;

        border-radius: 6px;

        font-size: 12px;

        font-weight: bold;

        white-space: nowrap;
    }

    .file-link:hover {
        background: #1d4ed8;
    }


    /* =========================
       KOSONG
    ========================= */

    .empty {
        text-align: center;

        padding: 40px;

        color: #64748b;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 1200px) {

        .filter-form {
            grid-template-columns:
                repeat(2, minmax(180px, 1fr));
        }

    }

    @media (max-width: 700px) {

        .filter-form {
            grid-template-columns: 1fr;
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')

<div class="riwayat-container">


    {{-- HEADER --}}

    <div class="riwayat-header">

        <h2>
            Riwayat Verifikasi
        </h2>

        <p>
            Cari dan filter dokumen yang sudah selesai diproses oleh Admin.
        </p>

    </div>


    {{-- KEMBALI --}}

    <div class="riwayat-actions">

        <a
            href="{{ route('verifikasi.index') }}"
            class="btn-kembali"
        >
            &larr; Kembali ke Verifikasi
        </a>

    </div>


    {{-- FILTER --}}

    <div class="filter-card">

        <div class="filter-title">
            Pencarian & Filter Riwayat
        </div>


        <form
            action="{{ route('verifikasi.riwayat') }}"
            method="GET"
            class="filter-form"
        >


            {{-- PENCARIAN --}}

            <div class="filter-group">

                <label>
                    Cari
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama dokumen / pengunggah / email"
                >

            </div>


            {{-- STATUS --}}

            <div class="filter-group">

                <label>
                    Status
                </label>

                <select name="status">

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="terverifikasi"
                        {{ request('status') === 'terverifikasi' ? 'selected' : '' }}
                    >
                        Terverifikasi
                    </option>

                    <option
                        value="ditolak"
                        {{ request('status') === 'ditolak' ? 'selected' : '' }}
                    >
                        Ditolak
                    </option>

                </select>

            </div>


            {{-- KLASTER --}}

            <div class="filter-group">

                <label>
                    Klaster
                </label>

                <select name="klaster_id">

                    <option value="">
                        Semua Klaster
                    </option>

                    @foreach($klasters as $klaster)

                        <option
                            value="{{ $klaster->id }}"
                            {{ (string) request('klaster_id') === (string) $klaster->id ? 'selected' : '' }}
                        >
                            {{ $klaster->nama_klaster }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- TAHUN --}}

            <div class="filter-group">

                <label>
                    Tahun
                </label>

                <select name="tahun">

                    <option value="">
                        Semua Tahun
                    </option>

                    @foreach($years as $tahun)

                        <option
                            value="{{ $tahun }}"
                            {{ (string) request('tahun') === (string) $tahun ? 'selected' : '' }}
                        >
                            {{ $tahun }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- TOMBOL FILTER --}}

            <button
                type="submit"
                class="btn-filter"
            >
                Terapkan
            </button>


            {{-- RESET --}}

            <a
                href="{{ route('verifikasi.riwayat') }}"
                class="btn-reset"
            >
                Reset
            </a>

        </form>

    </div>


    {{-- TABEL --}}

    <div class="riwayat-card">


        <div class="hasil-info">

            <span>
                Menampilkan
                <strong>
                    {{ $dokumens->count() }}
                </strong>
                dokumen
            </span>

            @if(
                request()->filled('search') ||
                request()->filled('status') ||
                request()->filled('klaster_id') ||
                request()->filled('tahun')
            )

                <span>
                    Filter sedang aktif
                </span>

            @endif

        </div>


        @if($dokumens->count() > 0)


            <div class="table-wrapper">


                <table class="riwayat-table">


                    <thead>

                        <tr>

                            <th>No</th>

                            <th>
                                Nama Dokumen
                            </th>

                            <th>
                                Pengunggah
                            </th>

                            <th>
                                Klaster
                            </th>

                            <th>
                                Program
                            </th>

                            <th>
                                Jenis Dokumen
                            </th>

                            <th>
                                Periode
                            </th>

                            <th>
                                Tahun
                            </th>

                            <th>
                                Tanggal Upload
                            </th>

                            <th>
                                Terakhir Diproses
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                File
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                        @foreach($dokumens as $dokumen)


                            <tr>


                                {{-- NO --}}

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                {{-- NAMA DOKUMEN --}}

                                <td>

                                    <strong>
                                        {{ $dokumen->nama_dokumen }}
                                    </strong>


                                    @if($dokumen->nama_file)

                                        <div style="
                                            margin-top:4px;
                                            font-size:11px;
                                            color:#64748b;
                                        ">

                                            {{ $dokumen->nama_file }}

                                        </div>

                                    @endif

                                </td>


                                {{-- PENGUNGGAH --}}

                                <td>


                                    @if($dokumen->user)


                                        <div class="pengunggah-name">

                                            {{ $dokumen->user->name }}

                                        </div>


                                        <div class="pengunggah-email">

                                            {{ $dokumen->user->email }}

                                        </div>


                                    @else


                                        <span style="color:#9ca3af;">

                                            Dokumen lama

                                        </span>


                                    @endif


                                </td>


                                {{-- KLASTER --}}

                                <td>

                                    {{ $dokumen->klaster->nama_klaster ?? '-' }}

                                </td>


                                {{-- PROGRAM --}}

                                <td>

                                    {{ $dokumen->program->nama_program ?? '-' }}

                                </td>


                                {{-- JENIS --}}

                                <td>

                                    {{ $dokumen->jenisDokumen->nama_jenis ?? '-' }}

                                </td>


                                {{-- PERIODE --}}

                                <td>

                                    {{ $dokumen->periode ?? '-' }}

                                </td>


                                {{-- TAHUN --}}

                                <td>

                                    {{ $dokumen->tahun ?? '-' }}

                                </td>


                                {{-- TANGGAL UPLOAD --}}

                                <td>

                                    {{ $dokumen->created_at?->format('d/m/Y H:i') ?? '-' }}

                                </td>


                                {{-- TERAKHIR DIPROSES --}}

                                <td>

                                    {{ $dokumen->updated_at?->format('d/m/Y H:i') ?? '-' }}

                                </td>


                                {{-- STATUS --}}

                                <td>


                                    @if($dokumen->status === 'terverifikasi')


                                        <span class="status status-terverifikasi">

                                            Terverifikasi

                                        </span>


                                    @elseif($dokumen->status === 'ditolak')


                                        <span class="status status-ditolak">

                                            Ditolak

                                        </span>


                                        @if($dokumen->alasan_penolakan)


                                            <div class="alasan">

                                                <strong>
                                                    Alasan:
                                                </strong>

                                                {{ $dokumen->alasan_penolakan }}

                                            </div>


                                        @endif


                                    @endif


                                </td>


                                {{-- FILE --}}

                                <td>


                                    <a
                                        href="{{ asset('storage/' . $dokumen->file_path) }}"
                                        target="_blank"
                                        class="file-link"
                                    >

                                        Lihat File

                                    </a>


                                </td>


                            </tr>


                        @endforeach


                    </tbody>


                </table>


            </div>


        @else


            <div class="empty">

                Tidak ada dokumen yang sesuai dengan pencarian atau filter.

            </div>


        @endif


    </div>


</div>

@endsection