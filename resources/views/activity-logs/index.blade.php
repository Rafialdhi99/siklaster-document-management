@extends('layouts.app')

@section('page-title', 'Audit Trail')

@push('styles')
<style>
    .audit-page {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .audit-header {
        background: linear-gradient(
            135deg,
            rgba(7, 89, 133, 0.08),
            rgba(14, 165, 164, 0.08),
            rgba(34, 197, 94, 0.08)
        );
        border: 1px solid #d9eeeb;
        border-radius: 16px;
        padding: 22px;
    }

    .audit-header h2 {
        margin: 0;
        font-size: 22px;
        color: #075985;
    }

    .audit-header p {
        margin: 7px 0 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    .audit-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .audit-filter {
        padding: 20px;
    }

    .audit-filter-grid {
        display: grid;
        grid-template-columns:
            minmax(220px, 2fr)
            minmax(170px, 1fr)
            minmax(170px, 1fr)
            minmax(160px, 1fr);
        gap: 14px;
        align-items: end;
    }

    .audit-field label {
        display: block;
        margin-bottom: 7px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
    }

    .audit-field input,
    .audit-field select {
        width: 100%;
        height: 42px;
        padding: 0 12px;
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        background: white;
        color: #1f2937;
        outline: none;
    }

    .audit-field input:focus,
    .audit-field select:focus {
        border-color: #0ea5a4;
        box-shadow: 0 0 0 3px rgba(14, 165, 164, 0.10);
    }

    .audit-buttons {
        display: flex;
        gap: 9px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .audit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 17px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .audit-btn-filter {
        color: white;
        background: linear-gradient(
            90deg,
            #075985,
            #0ea5a4
        );
    }

    .audit-btn-reset {
        color: #475569;
        background: #e2e8f0;
    }

    .audit-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .audit-table-header h3 {
        margin: 0;
        font-size: 16px;
        color: #075985;
    }

    .audit-total {
        padding: 6px 10px;
        border-radius: 999px;
        background: #ecfdf5;
        color: #15803d;
        font-size: 12px;
        font-weight: 700;
    }

    .audit-table-wrap {
        overflow-x: auto;
    }

    .audit-table {
        width: 100%;
        min-width: 1100px;
        border-collapse: collapse;
    }

    .audit-table th {
        padding: 13px 14px;
        text-align: left;
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .audit-table td {
        padding: 14px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: top;
        font-size: 13px;
        color: #334155;
    }

    .audit-table tbody tr:hover {
        background: #f8fffd;
    }

    .audit-user-name {
        font-weight: 700;
        color: #075985;
    }

    .audit-user-email {
        margin-top: 4px;
        color: #64748b;
        font-size: 11px;
    }

    .audit-action {
        display: inline-flex;
        align-items: center;
        padding: 6px 9px;
        border-radius: 999px;
        background: #ecfeff;
        color: #0e7490;
        font-size: 10px;
        font-weight: 800;
        white-space: nowrap;
    }

    .audit-description {
        max-width: 340px;
        line-height: 1.5;
    }

    .audit-ip {
        white-space: nowrap;
        font-family: monospace;
        font-size: 12px;
    }

    .audit-device {
        max-width: 280px;
        color: #64748b;
        font-size: 11px;
        line-height: 1.5;
        word-break: break-word;
    }

    .audit-empty {
        padding: 50px 20px !important;
        text-align: center;
        color: #64748b !important;
    }

    .audit-pagination {
        padding: 18px 20px;
    }

    @media (max-width: 1100px) {
        .audit-filter-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 650px) {
        .audit-filter-grid {
            grid-template-columns: 1fr;
        }

        .audit-header {
            padding: 18px;
        }

        .audit-table-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush


@section('content')

<div class="audit-page">

    <div class="audit-header">
        <h2>
            Riwayat Aktivitas Sistem
        </h2>

        <p>
            Mencatat aktivitas penting pengguna di dalam
            SIKLASTER seperti login, logout, upload,
            verifikasi, penolakan, perbaikan, dan
            penghapusan dokumen.
        </p>
    </div>


    <div class="audit-card audit-filter">

        <form
            method="GET"
            action="{{ route('activity-logs.index') }}"
        >

            <div class="audit-filter-grid">

                <div class="audit-field">
                    <label>
                        Pencarian
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Nama, email, IP, aktivitas..."
                    >
                </div>


                <div class="audit-field">
                    <label>
                        Pengguna
                    </label>

                    <select name="user_id">

                        <option value="">
                            Semua Pengguna
                        </option>

                        @foreach($users as $user)

                            <option
                                value="{{ $user->id }}"
                                @selected(
                                    request('user_id') == $user->id
                                )
                            >
                                {{ $user->name }}
                            </option>

                        @endforeach

                    </select>
                </div>


                <div class="audit-field">
                    <label>
                        Aktivitas
                    </label>

                    <select name="action">

                        <option value="">
                            Semua Aktivitas
                        </option>

                        @foreach($actions as $action)

                            <option
                                value="{{ $action }}"
                                @selected(
                                    request('action') === $action
                                )
                            >
                                {{
                                    ucwords(
                                        str_replace(
                                            '_',
                                            ' ',
                                            $action
                                        )
                                    )
                                }}
                            </option>

                        @endforeach

                    </select>
                </div>


                <div class="audit-field">
                    <label>
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                    >
                </div>

            </div>


            <div class="audit-buttons">

                <button
                    type="submit"
                    class="audit-btn audit-btn-filter"
                >
                    Filter Data
                </button>

                <a
                    href="{{ route('activity-logs.index') }}"
                    class="audit-btn audit-btn-reset"
                >
                    Reset
                </a>

            </div>

        </form>

    </div>


    <div class="audit-card">

        <div class="audit-table-header">

            <h3>
                Daftar Audit Trail
            </h3>

            <span class="audit-total">
                {{ $logs->total() }} aktivitas
            </span>

        </div>


        <div class="audit-table-wrap">

            <table class="audit-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Keterangan</th>
                        <th>IP Address</th>
                        <th>Perangkat / Browser</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <td>
                                {{
                                    $logs->firstItem()
                                    + $loop->index
                                }}
                            </td>


                            <td style="white-space: nowrap;">
                                {{
                                    $log->created_at
                                        ?->format(
                                            'd-m-Y H:i:s'
                                        )
                                }}
                            </td>


                            <td>

                                @if($log->user)

                                    <div class="audit-user-name">
                                        {{ $log->user->name }}
                                    </div>

                                    <div class="audit-user-email">
                                        {{ $log->user->email }}
                                    </div>

                                @else

                                    <span style="color:#94a3b8;">
                                        Pengguna tidak tersedia
                                    </span>

                                @endif

                            </td>


                            <td>

                                <span class="audit-action">

                                    {{
                                        strtoupper(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $log->action
                                            )
                                        )
                                    }}

                                </span>

                            </td>


                            <td>
                                <div class="audit-description">
                                    {{
                                        $log->description
                                        ?? '-'
                                    }}
                                </div>
                            </td>


                            <td>
                                <span class="audit-ip">
                                    {{
                                        $log->ip_address
                                        ?? '-'
                                    }}
                                </span>
                            </td>


                            <td>
                                <div class="audit-device">
                                    {{
                                        $log->user_agent
                                        ?? '-'
                                    }}
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="7"
                                class="audit-empty"
                            >
                                Belum ada data Audit Trail.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($logs->hasPages())

            <div class="audit-pagination">
                {{ $logs->links() }}
            </div>

        @endif

    </div>

</div>

@endsection