@extends('layouts.app')

@section('title', 'Data Dokumen - SIKLASTER')
@section('page-title', 'Data Dokumen')

@push('styles')
<style>
    .dokumen-container {
        background: white;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        border: 1px solid #edf0f5;
    }

    .dokumen-header {
        margin-bottom: 25px;
    }

    .dokumen-header h2 {
        margin: 0 0 5px;
        font-size: 22px;
    }

    .dokumen-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }


    /* =========================
       FILTER
    ========================= */

    .filter-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr 0.8fr 1fr;
        gap: 15px;
        align-items: end;
    }

    .filter-item {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .filter-item label {
        font-size: 13px;
        color: #374151;
        font-weight: bold;
    }

    .filter-item input,
    .filter-item select {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        font-family: inherit;
        outline: none;
    }

    .filter-item input:focus,
    .filter-item select:focus {
        border-color: #2563eb;
    }

    .filter-buttons {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 18px;
    }

    .btn-cari {
        padding: 11px 24px;
        border: none;
        border-radius: 8px;
        background: #2563eb;
        color: white;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-cari:hover {
        background: #1d4ed8;
    }

    .reset-link {
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
    }

    .reset-link:hover {
        color: #2563eb;
    }


    /* =========================
       TABLE
    ========================= */

    .table-wrapper {
        overflow-x: auto;
    }

    .dokumen-table {
        min-width: 1050px;
        width: 100%;
        border-collapse: collapse;
    }

    .dokumen-table th {
        background: #f8fafc;
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 12px 10px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }

    .dokumen-table td {
        font-size: 13px;
        padding: 14px 10px;
        border-bottom: 1px solid #f0f1f4;
        vertical-align: top;
    }

    .dokumen-table tbody tr:hover {
        background: #f8fafc;
    }


    /* =========================
       STATUS
    ========================= */

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        white-space: nowrap;
    }

    .status.menunggu {
        background: #fff3cd;
        color: #856404;
    }

    .status.disetujui {
        background: #d1fae5;
        color: #065f46;
    }

    .status.ditolak {
        background: #fee2e2;
        color: #991b1b;
    }

    .alasan-penolakan {
        margin-top: 7px;
        font-size: 11px;
        line-height: 1.5;
        color: #991b1b;
        max-width: 230px;
    }


    /* =========================
       ACTION
    ========================= */

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 110px;
    }

    .action-link {
        display: inline-block;
        text-align: center;
        padding: 7px 10px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }

    .detail-link {
        background: #172033;
        color: white;
    }

    .detail-link:hover {
        background: #26334d;
    }

    .preview-link {
        background: #eff6ff;
        color: #2563eb;
    }

    .preview-link:hover {
        background: #dbeafe;
    }

    .perbaiki-link {
        background: #f59e0b;
        color: white;
    }

    .perbaiki-link:hover {
        background: #d97706;
    }

    .hapus-link {
    width: 100%;
    background: #dc2626;
    color: white;
}

.hapus-link:hover {
    background: #b91c1c;
}

.delete-form {
    margin: 0;
    width: 100%;
}

    .empty {
        text-align: center;
        padding: 40px !important;
        color: #6b7280;
    }


    /* =========================
       MODAL PREVIEW
    ========================= */

    .preview-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(15, 23, 42, 0.72);
        padding: 25px;
        align-items: center;
        justify-content: center;
    }

    .preview-modal.active {
        display: flex;
    }

    .preview-box {
        background: white;
        width: 95%;
        max-width: 1200px;
        height: 92vh;
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 60px rgba(0,0,0,0.30);
    }

    .preview-header {
        min-height: 64px;
        padding: 14px 18px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        background: white;
    }

    .preview-title-area {
        min-width: 0;
    }

    .preview-title {
        margin: 0;
        font-size: 17px;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .preview-subtitle {
        margin: 4px 0 0;
        font-size: 12px;
        color: #6b7280;
    }

    .preview-close {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 8px;
        background: #f3f4f6;
        color: #111827;
        font-size: 23px;
        cursor: pointer;
        line-height: 1;
    }

    .preview-close:hover {
        background: #e5e7eb;
    }

    .preview-content {
        position: relative;
        flex: 1;
        min-height: 0;
        background: #f1f5f9;
    }

    .preview-frame {
        width: 100%;
        height: 100%;
        border: 0;
        display: none;
        background: white;
    }

    .preview-image-wrapper {
        width: 100%;
        height: 100%;
        overflow: auto;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 25px;
        box-sizing: border-box;
    }

    .preview-image {
        display: block;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 6px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.12);
        background: white;
    }

    .preview-not-supported {
        display: none;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
        padding: 30px;
        box-sizing: border-box;
        text-align: center;
    }

    .preview-message-box {
        background: white;
        max-width: 550px;
        width: 100%;
        border-radius: 14px;
        padding: 35px 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .preview-file-icon {
        font-size: 50px;
        margin-bottom: 15px;
    }

    .preview-message-box h3 {
        margin: 0 0 10px;
        font-size: 19px;
        color: #111827;
    }

    .preview-message-box p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
    }

    .preview-loading {
        position: absolute;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        z-index: 2;
    }

    .preview-loading.active {
        display: flex;
    }

    .loading-box {
        background: white;
        padding: 18px 25px;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        color: #475569;
        font-size: 14px;
        font-weight: bold;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 1100px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 650px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }

        .preview-modal {
            padding: 8px;
        }

        .preview-box {
            width: 100%;
            height: 96vh;
            border-radius: 10px;
        }

        .preview-header {
            padding: 11px 12px;
        }

        .preview-title {
            font-size: 14px;
        }
    }
</style>
@endpush


@section('content')

<div class="dokumen-container">

    <div class="dokumen-header">

        <h2>
            Data Dokumen
        </h2>

        <p>
            Kelola dan pantau seluruh dokumen Puskesmas Sawah Lega.
        </p>

    </div>


    {{-- =========================
         FILTER
    ========================= --}}

    <form
        action="{{ url('/dokumens') }}"
        method="GET"
    >

        <div class="filter-box">

            <div class="filter-grid">

                {{-- PENCARIAN --}}

                <div class="filter-item">

                    <label for="search">
                        Cari Dokumen
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Kode SIKLASTER, nama dokumen, file, atau deskripsi..."
                    >

                </div>


                {{-- KLASTER --}}

                <div class="filter-item">

                    <label for="klaster_filter">
                        Klaster
                    </label>

                    <select
                        name="klaster_id"
                        id="klaster_filter"
                    >

                        <option value="">
                            Semua Klaster
                        </option>

                        @foreach($klasters as $klaster)

                            <option
                                value="{{ $klaster->id }}"
                                {{ request('klaster_id') == $klaster->id ? 'selected' : '' }}
                            >
                                {{ $klaster->kode_klaster }}
                                -
                                {{ $klaster->nama_klaster }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- PROGRAM --}}

                <div class="filter-item">

                    <label for="program_filter">
                        Program
                    </label>

                    <select
                        name="program_id"
                        id="program_filter"
                    >

                        <option value="">
                            Semua Program
                        </option>

                        @foreach($programs as $program)

                            <option
                                value="{{ $program->id }}"
                                data-klaster="{{ $program->klaster_id }}"
                                {{ request('program_id') == $program->id ? 'selected' : '' }}
                            >
                                {{ $program->kode_program }}
                                -
                                {{ $program->nama_program }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- TAHUN --}}

                <div class="filter-item">

                    <label for="tahun_filter">
                        Tahun
                    </label>

                    <select
                        name="tahun"
                        id="tahun_filter"
                    >

                        <option value="">
                            Semua Tahun
                        </option>

                        @foreach($years as $year)

                            <option
                                value="{{ $year }}"
                                {{ request('tahun') == $year ? 'selected' : '' }}
                            >
                                {{ $year }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- STATUS --}}

                <div class="filter-item">

                    <label for="status_filter">
                        Status
                    </label>

                    <select
                        name="status"
                        id="status_filter"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="menunggu_verifikasi"
                            {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}
                        >
                            Menunggu Verifikasi
                        </option>

                        <option
                            value="terverifikasi"
                            {{ request('status') == 'terverifikasi' ? 'selected' : '' }}
                        >
                            Terverifikasi
                        </option>

                        <option
                            value="ditolak"
                            {{ request('status') == 'ditolak' ? 'selected' : '' }}
                        >
                            Ditolak
                        </option>

                    </select>

                </div>

            </div>

{{-- JENIS DOKUMEN --}}

<div class="filter-item">

    <label for="jenis_dokumen_filter">
        Jenis Dokumen
    </label>

    <select
        name="jenis_dokumen_id"
        id="jenis_dokumen_filter"
    >

        <option value="">
            Semua Jenis Dokumen
        </option>

        @foreach($jenisDokumens as $jenisDokumen)

            <option
                value="{{ $jenisDokumen->id }}"
                {{ request('jenis_dokumen_id') == $jenisDokumen->id ? 'selected' : '' }}
            >
                {{ $jenisDokumen->nama_jenis }}
            </option>

        @endforeach

    </select>

</div>


{{-- PERIODE --}}

<div class="filter-item">

    <label for="periode_filter">
        Periode
    </label>

    <select
        name="periode"
        id="periode_filter"
    >

        <option value="">
            Semua Periode
        </option>

        @foreach($periodes as $periode)

            <option
                value="{{ $periode }}"
                {{ request('periode') == $periode ? 'selected' : '' }}
            >
                {{ $periode }}
            </option>

        @endforeach

    </select>

</div>


{{-- PENGUNGGAH --}}

<div class="filter-item">

    <label for="user_filter">
        Pengunggah
    </label>

    <select
        name="user_id"
        id="user_filter"
    >

        <option value="">
            Semua Pengunggah
        </option>

        @foreach($users as $user)

            <option
                value="{{ $user->id }}"
                {{ request('user_id') == $user->id ? 'selected' : '' }}
            >
                {{ $user->name }}
            </option>

        @endforeach

    </select>

</div>
            <div class="filter-buttons">

                <button
                    type="submit"
                    class="btn-cari"
                >
                    Cari
                </button>


                @if(
    request('search') ||
    request('klaster_id') ||
    request('program_id') ||
    request('tahun') ||
    request('status') ||
    request('jenis_dokumen_id') ||
    request('periode') ||
    request('user_id')
)

                    <a
                        href="{{ url('/dokumens') }}"
                        class="reset-link"
                    >
                        Reset Filter
                    </a>

                @endif

            </div>

        </div>

    </form>


    {{-- =========================
         TABEL DOKUMEN
    ========================= --}}

    <div class="table-wrapper">

        <table class="dokumen-table">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Klaster</th>
                    <th>Program</th>
                    <th>Jenis Dokumen</th>
                    <th>Periode</th>
                    <th>Tahun</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                @forelse($dokumens as $index => $dokumen)

                    <tr>

                        <td>
                            {{ $index + 1 }}
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

    <strong>
        {{ $dokumen->nama_dokumen }}
    </strong>

</td>


                        <td>
                            {{ $dokumen->klaster->nama_klaster ?? '-' }}
                        </td>


                        <td>
                            {{ $dokumen->program->nama_program ?? '-' }}
                        </td>


                        <td>
                            {{ $dokumen->jenisDokumen->nama_jenis ?? '-' }}
                        </td>


                        <td>
                            {{ $dokumen->periode ?? '-' }}
                        </td>


                        <td>
                            {{ $dokumen->tahun ?? '-' }}
                        </td>


                        {{-- STATUS --}}

                        <td>

                            @if($dokumen->status === 'menunggu_verifikasi')

                                <span class="status menunggu">
                                    Menunggu Verifikasi
                                </span>


                            @elseif($dokumen->status === 'terverifikasi')

                                <span class="status disetujui">
                                    Terverifikasi
                                </span>


                            @elseif($dokumen->status === 'ditolak')

                                <span class="status ditolak">
                                    Ditolak
                                </span>


                                @if($dokumen->alasan_penolakan)

                                    <div class="alasan-penolakan">

                                        <strong>
                                            Alasan:
                                        </strong>

                                        {{ $dokumen->alasan_penolakan }}

                                    </div>

                                @endif


                            @else

                                <span class="status">
                                    {{ $dokumen->status }}
                                </span>

                            @endif

                        </td>


                        {{-- AKSI --}}

                        <td>

                            <div class="action-buttons">

                                {{-- DETAIL --}}

                                <a
                                    href="{{ route('dokumens.show', $dokumen) }}"
                                    class="action-link detail-link"
                                >
                                    Detail
                                </a>


                                {{-- LIHAT FILE --}}

                                <button
    type="button"
    class="action-link preview-link"
    onclick="openPreview(
        '{{ route('dokumens.preview', $dokumen) }}',
        @js($dokumen->nama_file),
        @js($dokumen->nama_dokumen)
    )"
>
    Lihat File
</button>


                                {{-- PERBAIKI JIKA DITOLAK --}}

@if(
    $dokumen->status === 'ditolak' &&
    (
        auth()->user()->role === 'admin' ||
        $dokumen->user_id === auth()->id()
    )
)

    <a
        href="{{ route('dokumens.perbaiki', $dokumen) }}"
        class="action-link perbaiki-link"
    >
        Perbaiki
    </a>

@endif


{{-- HAPUS DOKUMEN --}}

@if(
    auth()->user()->role === 'admin' ||
    (
        $dokumen->user_id === auth()->id() &&
        in_array(
            $dokumen->status,
            ['menunggu_verifikasi', 'ditolak']
        )
    )
)

    <form
        action="{{ route('dokumens.destroy', $dokumen) }}"
        method="POST"
        class="delete-form"
        onsubmit="return confirm('Yakin ingin menghapus dokumen ini? File yang sudah dihapus tidak dapat dikembalikan.');"
    >

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="action-link hapus-link"
        >
            Hapus
        </button>

    </form>

@endif

                            </div>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="9"
                            class="empty"
                        >
                            Belum ada dokumen yang tersedia.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- =====================================================
     MODAL PREVIEW
===================================================== --}}

<div
    id="previewModal"
    class="preview-modal"
    onclick="closePreviewFromBackground(event)"
>

    <div class="preview-box">

        <div class="preview-header">

            <div class="preview-title-area">

                <h3
                    class="preview-title"
                    id="previewTitle"
                >
                    Preview Dokumen
                </h3>

                <p
                    class="preview-subtitle"
                    id="previewFileName"
                ></p>

            </div>


            <button
                type="button"
                class="preview-close"
                onclick="closePreview()"
                title="Tutup"
            >
                &times;
            </button>

        </div>


        <div class="preview-content">

            {{-- Loading --}}

            <div
                id="previewLoading"
                class="preview-loading"
            >

                <div class="loading-box">
                    Memuat dokumen...
                </div>

            </div>


            {{-- PDF --}}

            <iframe
                id="previewFrame"
                class="preview-frame"
                src=""
                title="Preview Dokumen"
            ></iframe>


            {{-- IMAGE --}}

            <div
                id="previewImageWrapper"
                class="preview-image-wrapper"
            >

                <img
                    id="previewImage"
                    class="preview-image"
                    src=""
                    alt="Preview Dokumen"
                >

            </div>


            {{-- FILE OFFICE / TIDAK DIDUKUNG --}}

            <div
                id="previewNotSupported"
                class="preview-not-supported"
            >

                <div class="preview-message-box">

                    <div class="preview-file-icon">
                        📄
                    </div>

                    <h3>
                        Preview belum tersedia
                    </h3>

                    <p>
                        Format dokumen ini tidak dapat ditampilkan
                        langsung oleh browser.
                        <br><br>
                        Untuk menjaga dokumen internal tetap privat,
                        SIKLASTER tidak mengirim file ke layanan
                        preview pihak ketiga.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | FILTER KLASTER & PROGRAM
    |--------------------------------------------------------------------------
    */

    const klasterFilter =
        document.getElementById('klaster_filter');

    const programFilter =
        document.getElementById('program_filter');


    function filterPrograms() {

        if (!klasterFilter || !programFilter) {
            return;
        }

        const klasterId =
            klasterFilter.value;


        for (
            let i = 0;
            i < programFilter.options.length;
            i++
        ) {

            const option =
                programFilter.options[i];


            if (option.value === '') {

                option.hidden = false;

                continue;
            }


            if (klasterId === '') {

                option.hidden = false;

                continue;
            }


            /*
            | Tampilkan hanya program dari klaster yang dipilih.
            */

            option.hidden =
                option.dataset.klaster !== klasterId;
        }


        const selected =
            programFilter.options[
                programFilter.selectedIndex
            ];


        if (
            selected &&
            selected.value !== '' &&
            selected.hidden
        ) {
            programFilter.value = '';
        }
    }


    if (klasterFilter && programFilter) {

        klasterFilter.addEventListener(
            'change',
            filterPrograms
        );

        filterPrograms();
    }



    /*
    |--------------------------------------------------------------------------
    | PREVIEW DOKUMEN
    |--------------------------------------------------------------------------
    */

    const previewModal =
        document.getElementById('previewModal');

    const previewFrame =
        document.getElementById('previewFrame');

    const previewImageWrapper =
        document.getElementById('previewImageWrapper');

    const previewImage =
        document.getElementById('previewImage');

    const previewNotSupported =
        document.getElementById('previewNotSupported');

    const previewLoading =
        document.getElementById('previewLoading');

    const previewTitle =
        document.getElementById('previewTitle');

    const previewFileName =
        document.getElementById('previewFileName');


    function getFileExtension(fileName) {

        if (!fileName || !fileName.includes('.')) {
            return '';
        }

        return fileName
            .split('.')
            .pop()
            .toLowerCase();
    }


    function resetPreview() {

        previewFrame.style.display = 'none';
        previewFrame.src = '';

        previewImageWrapper.style.display = 'none';
        previewImage.src = '';

        previewNotSupported.style.display = 'none';

        previewLoading.classList.remove('active');
    }


    function openPreview(
    previewUrl,
    fileName,
    documentName
)  {

    resetPreview();

    previewTitle.textContent =
        documentName || 'Preview Dokumen';

    previewFileName.textContent =
        fileName || '';

    previewModal.classList.add('active');

    document.body.style.overflow = 'hidden';


    const extension =
        getFileExtension(fileName);


    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    if (extension === 'pdf') {

        previewLoading.classList.add('active');

        previewFrame.style.display = 'block';

        previewFrame.onload = function () {
            previewLoading.classList.remove('active');
        };

        previewFrame.src = previewUrl;

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | GAMBAR
    |--------------------------------------------------------------------------
    */

    if (
        extension === 'jpg' ||
        extension === 'jpeg' ||
        extension === 'png'
    ) {

        previewLoading.classList.add('active');

        previewImageWrapper.style.display = 'flex';

        previewImage.onload = function () {
            previewLoading.classList.remove('active');
        };

        previewImage.onerror = function () {

            previewLoading.classList.remove('active');

            previewImageWrapper.style.display = 'none';

            previewNotSupported.style.display = 'flex';
        };

        previewImage.src = previewUrl;

        return;
    }

 /*
    |--------------------------------------------------------------------------
    | FORMAT BELUM DIDUKUNG
    |--------------------------------------------------------------------------
    */

    previewNotSupported.style.display = 'flex';
}


function closePreview() {

    resetPreview();

    previewModal.classList.remove('active');

    document.body.style.overflow = '';
}


function closePreviewFromBackground(event) {

    if (event.target === previewModal) {
        closePreview();
    }
}
    /*
    |--------------------------------------------------------------------------
    | ESC UNTUK MENUTUP POPUP
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                previewModal.classList.contains('active')
            ) {
                closePreview();
            }
        }
    );

</script>

@endpush