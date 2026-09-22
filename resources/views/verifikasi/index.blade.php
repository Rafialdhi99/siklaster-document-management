@extends('layouts.app')

@section('title', 'Verifikasi Dokumen - SIKLASTER')
@section('page-title', 'Verifikasi Dokumen')

@push('styles')
<style>
    .verifikasi-container {
        width: 100%;
    }

    .verifikasi-header {
        background: #172033;
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .verifikasi-header h2 {
        margin: 0 0 5px;
        font-size: 26px;
    }

    .verifikasi-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }

    .toolbar {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 20px;
    }

    .btn-riwayat {
        display: inline-block;
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: bold;
        transition: 0.2s;
    }

    .btn-riwayat:hover {
        background: #1d4ed8;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .verifikasi-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .verifikasi-table {
        width: 100%;
        min-width: 1450px;
        border-collapse: collapse;
    }

    .verifikasi-table th {
        background: #f1f5f9;
        text-align: left;
        padding: 13px;
        font-size: 12px;
        color: #475569;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .verifikasi-table td {
        padding: 13px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 13px;
        vertical-align: top;
    }

    .pengunggah-name {
        font-weight: bold;
        color: #1f2937;
    }

    .pengunggah-email {
        font-size: 11px;
        color: #64748b;
        margin-top: 3px;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        white-space: nowrap;
    }

    .status-menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .file-link {
        display: inline-block;
        padding: 7px 11px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
        white-space: nowrap;
        cursor: pointer;
        font-family: inherit;
    }

    .file-link:hover {
        background: #1d4ed8;
    }

    .actions {
        min-width: 230px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .actions form {
        margin: 0;
    }

    .btn {
        width: 100%;
        border: none;
        padding: 9px 12px;
        border-radius: 6px;
        color: white;
        cursor: pointer;
        font-size: 12px;
        font-weight: bold;
    }

    .btn-setujui {
        background: #16a34a;
    }

    .btn-setujui:hover {
        background: #15803d;
    }

    .btn-tolak {
        background: #dc2626;
    }

    .btn-tolak:hover {
        background: #b91c1c;
    }

    .alasan-box {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-bottom: 7px;
    }

    .alasan-box label {
        font-size: 11px;
        color: #6b7280;
        font-weight: bold;
    }

    .alasan-box textarea {
        width: 100%;
        min-height: 70px;
        resize: vertical;
        padding: 8px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        box-sizing: border-box;
    }

    .alasan-box textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
    }

    .empty {
        text-align: center;
        padding: 40px;
        color: #64748b;
    }


    /* =========================
       POPUP PREVIEW
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
        background: white;
        border-radius: 6px;
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

    .preview-message-box h3 {
        margin: 0 0 10px;
        color: #111827;
    }

    .preview-message-box p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
    }

    .preview-file-icon {
        font-size: 50px;
        margin-bottom: 15px;
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

    @media (max-width: 650px) {
        .preview-modal {
            padding: 8px;
        }

        .preview-box {
            width: 100%;
            height: 96vh;
            border-radius: 10px;
        }
    }
</style>
@endpush


@section('content')

<div class="verifikasi-container">

    <div class="verifikasi-header">

        <h2>
            Verifikasi Dokumen
        </h2>

        <p>
            Periksa dokumen yang dikirim pengguna sebelum disetujui atau ditolak.
        </p>

    </div>


    <div class="toolbar">

        <a
            href="{{ route('verifikasi.riwayat') }}"
            class="btn-riwayat"
        >
            Riwayat Verifikasi
        </a>

    </div>


    @if(session('success'))

        <div class="alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="alert-error">
            {{ session('error') }}
        </div>

    @endif


    <div class="verifikasi-card">

        @if($dokumens->count() > 0)

            <div class="table-wrapper">

                <table class="verifikasi-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>Nama Dokumen</th>
                            <th>Pengunggah</th>
                            <th>Klaster</th>
                            <th>Program</th>
                            <th>Jenis Dokumen</th>
                            <th>Deskripsi</th>
                            <th>Periode</th>
                            <th>Tahun</th>
                            <th>Tanggal Upload</th>
                            <th>File</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($dokumens as $dokumen)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
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
                                    {{ $dokumen->deskripsi ?? '-' }}
                                </td>


                                <td>
                                    {{ $dokumen->periode ?? '-' }}
                                </td>


                                <td>
                                    {{ $dokumen->tahun ?? '-' }}
                                </td>


                                <td>
                                    {{ $dokumen->created_at?->format('d/m/Y H:i') ?? '-' }}
                                </td>


                                {{-- LIHAT FILE --}}

                                <td>

                                    <button
    type="button"
    class="file-link"
    onclick="openPreview(
        '{{ route('dokumens.preview', $dokumen) }}',
        @js($dokumen->nama_file),
        @js($dokumen->nama_dokumen)
    )"
>
    Lihat File
</button>
                                </td>


                                <td>

                                    <span class="status status-menunggu">
                                        Menunggu Verifikasi
                                    </span>

                                </td>


                                <td>

                                    <div class="actions">


                                        {{-- SETUJUI --}}

                                        <form
                                            action="{{ route('verifikasi.setujui', $dokumen) }}"
                                            method="POST"
                                            onsubmit="return confirm('Setujui dokumen ini?');"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="btn btn-setujui"
                                            >
                                                Setujui
                                            </button>

                                        </form>


                                        {{-- TOLAK --}}

                                        <form
                                            action="{{ route('verifikasi.tolak', $dokumen) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menolak dokumen ini?');"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <div class="alasan-box">

                                                <label>
                                                    Alasan Penolakan
                                                </label>

                                                <textarea
                                                    name="alasan_penolakan"
                                                    placeholder="Contoh: Dokumen belum lengkap"
                                                    required
                                                ></textarea>

                                            </div>

                                            <button
                                                type="submit"
                                                class="btn btn-tolak"
                                            >
                                                Tolak Dokumen
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">
                Tidak ada dokumen yang menunggu verifikasi.
            </div>

        @endif

    </div>

</div>



{{-- =========================
     POPUP PREVIEW
========================= --}}

<div
    id="previewModal"
    class="preview-modal"
    onclick="closePreviewFromBackground(event)"
>

    <div class="preview-box">

        <div class="preview-header">

            <div class="preview-title-area">

                <h3
                    id="previewTitle"
                    class="preview-title"
                >
                    Preview Dokumen
                </h3>

                <p
                    id="previewFileName"
                    class="preview-subtitle"
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

            <div
                id="previewLoading"
                class="preview-loading"
            >
                <div class="loading-box">
                    Memuat dokumen...
                </div>
            </div>


            <iframe
                id="previewFrame"
                class="preview-frame"
                src=""
                title="Preview Dokumen"
            ></iframe>


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
) {

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
    | ESC = TUTUP POPUP
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