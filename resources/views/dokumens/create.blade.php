@extends('layouts.app')

@section('title', 'Upload Dokumen - SIKLASTER')
@section('page-title', 'Upload Dokumen')

@section('content')

<style>
    .upload-container {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .upload-header {
        background: #172033;
        color: white;
        padding: 28px 32px;
        border-radius: 14px;
        margin-bottom: 24px;
    }

    .upload-header h2 {
        margin: 0 0 6px;
        font-size: 26px;
    }

    .upload-header p {
        margin: 0;
        color: #cbd5e1;
        font-size: 14px;
    }

    .upload-card {
        background: white;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 16px 18px;
        border-radius: 10px;
        margin-bottom: 24px;
    }

    .alert-error strong {
        display: block;
        margin-bottom: 8px;
    }

    .alert-error ul {
        margin: 0;
        padding-left: 20px;
    }

    .alert-error li {
        margin-bottom: 4px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #172033;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        display: block;
        width: 100%;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: white;
        color: #1f2937;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
    }

    .form-group textarea {
        min-height: 110px;
        resize: vertical;
    }

    .input-error {
        border-color: #dc2626 !important;
        background: #fff7f7 !important;
    }

    .field-error {
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 600;
    }

    .form-help {
        margin-top: 7px;
        font-size: 12px;
        line-height: 1.5;
        color: #6b7280;
    }

    .file-box {
        padding: 14px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
    }

    .file-box input[type="file"] {
        border: none;
        padding: 0;
        background: transparent;
    }

    .form-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 10px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-upload {
        border: none;
        border-radius: 8px;
        padding: 12px 22px;
        background: #2563eb;
        color: white;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-upload:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .required {
        color: #dc2626;
    }

    @media (max-width: 650px) {
        .upload-container {
            max-width: 100%;
        }

        .upload-card {
            padding: 20px;
        }

        .upload-header {
            padding: 22px;
        }

        .upload-header h2 {
            font-size: 22px;
        }

        .form-footer {
            justify-content: stretch;
        }

        .btn-upload {
            width: 100%;
        }
    }
</style>


<div class="upload-container">

    {{-- HEADER --}}
    <div class="upload-header">

        <h2>Upload Dokumen</h2>

        <p>
            Tambahkan dokumen baru ke dalam SIKLASTER PKM SAWAH LEGA
        </p>

    </div>


    {{-- FORM --}}
    <div class="upload-card">

        {{-- ERROR VALIDASI --}}
        @if ($errors->any())

            <div class="alert-error">

                <strong>Upload gagal. Periksa data berikut:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        <form
            action="{{ url('/dokumens/upload') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            {{-- KLASTER --}}
            <div class="form-group">

                <label for="klaster_id">
                    Klaster <span class="required">*</span>
                </label>

                <select
                    name="klaster_id"
                    id="klaster_id"
                    class="@error('klaster_id') input-error @enderror"
                    required
                >

                    <option value="">
                        -- Pilih Klaster --
                    </option>

                    @foreach ($klasters as $klaster)

                        <option
                            value="{{ $klaster->id }}"
                            {{ old('klaster_id') == $klaster->id ? 'selected' : '' }}
                        >

                            {{ $klaster->kode_klaster }}
                            -
                            {{ $klaster->nama_klaster }}

                        </option>

                    @endforeach

                </select>

                @error('klaster_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- PROGRAM --}}
            <div class="form-group">

                <label for="program_id">
                    Program / Subklaster <span class="required">*</span>
                </label>

                <select
                    name="program_id"
                    id="program_id"
                    class="@error('program_id') input-error @enderror"
                    required
                    disabled
                >

                    <option value="">
                        -- Pilih Klaster terlebih dahulu --
                    </option>

                </select>

                @error('program_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- JENIS DOKUMEN --}}
            <div class="form-group">

                <label for="jenis_dokumen_id">
                    Jenis Dokumen <span class="required">*</span>
                </label>

                <select
                    name="jenis_dokumen_id"
                    id="jenis_dokumen_id"
                    class="@error('jenis_dokumen_id') input-error @enderror"
                    required
                >

                    <option value="">
                        -- Pilih Jenis Dokumen --
                    </option>

                    @foreach ($jenisDokumens as $jenis)

                        <option
                            value="{{ $jenis->id }}"
                            {{ old('jenis_dokumen_id') == $jenis->id ? 'selected' : '' }}
                        >

                            {{ $jenis->kode_jenis }}
                            -
                            {{ $jenis->nama_jenis }}

                        </option>

                    @endforeach

                </select>

                @error('jenis_dokumen_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- NAMA DOKUMEN --}}
            <div class="form-group">

                <label for="nama_dokumen">
                    Nama Dokumen <span class="required">*</span>
                </label>

                <input
                    type="text"
                    name="nama_dokumen"
                    id="nama_dokumen"
                    value="{{ old('nama_dokumen') }}"
                    class="@error('nama_dokumen') input-error @enderror"
                    placeholder="Contoh: Laporan Imunisasi Juli 2026"
                    required
                >

                @error('nama_dokumen')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- DESKRIPSI --}}
            <div class="form-group">

                <label for="deskripsi">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    id="deskripsi"
                    class="@error('deskripsi') input-error @enderror"
                    placeholder="Keterangan tambahan mengenai dokumen"
                >{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- PERIODE --}}
            <div class="form-group">

                <label for="periode">
                    Periode
                </label>

                <input
                    type="text"
                    name="periode"
                    id="periode"
                    value="{{ old('periode') }}"
                    class="@error('periode') input-error @enderror"
                    placeholder="Contoh: Juli / Triwulan I / Semester I"
                >

                @error('periode')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- TAHUN --}}
            <div class="form-group">

                <label for="tahun">
                    Tahun <span class="required">*</span>
                </label>

                <input
                    type="number"
                    name="tahun"
                    id="tahun"
                    value="{{ old('tahun', 2026) }}"
                    class="@error('tahun') input-error @enderror"
                    min="2000"
                    max="2100"
                    required
                >

                @error('tahun')
                    <div class="field-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- FILE --}}
            <div class="form-group">

                <label for="file">
                    File Dokumen <span class="required">*</span>
                </label>

                <div class="file-box">

                    <input
                        type="file"
                        name="file"
                        id="file"
                        class="@error('file') input-error @enderror"
                        required
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png"
                    >

                    @error('file')
                        <div class="field-error">{{ $message }}</div>
                    @enderror

                    <div class="form-help">

                        Format yang diperbolehkan:
                        PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX,
                        JPG, JPEG, PNG.

                        <br>

                        Batas sistem saat ini: Maksimal 500 MB.

                    </div>

                </div>

            </div>


            {{-- BUTTON --}}
            <div class="form-footer">

                <button
                    type="submit"
                    class="btn-upload"
                >
                    ⬆️ Upload Dokumen
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================
     JAVASCRIPT PROGRAM
========================= --}}

@push('scripts')

<script>

    const programs = @json($programs);

    const klasterSelect =
        document.getElementById('klaster_id');

    const programSelect =
        document.getElementById('program_id');

    const oldProgramId =
        @json(old('program_id'));

    function loadPrograms(klasterId, selectedProgramId = null) {

        programSelect.innerHTML =
            '<option value="">-- Pilih Program --</option>';

        if (!klasterId) {

            programSelect.disabled = true;

            return;
        }

        const filteredPrograms =
            programs.filter(function (program) {

                return program.klaster_id == klasterId;

            });

        filteredPrograms.forEach(function (program) {

            const option =
                document.createElement('option');

            option.value = program.id;

            option.textContent =
                program.kode_program +
                ' - ' +
                program.nama_program;

            if (
                selectedProgramId &&
                program.id == selectedProgramId
            ) {
                option.selected = true;
            }

            programSelect.appendChild(option);

        });

        programSelect.disabled = false;
    }


    klasterSelect.addEventListener('change', function () {

        loadPrograms(this.value);

    });


    if (klasterSelect.value) {

        loadPrograms(
            klasterSelect.value,
            oldProgramId
        );

    }

</script>

@endpush

@endsection