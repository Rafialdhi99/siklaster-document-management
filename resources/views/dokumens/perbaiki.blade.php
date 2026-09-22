@extends('layouts.app')

@section('title', 'Perbaiki Dokumen - SIKLASTER')
@section('page-title', 'Perbaiki Dokumen')

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 14px;
        padding: 30px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.06);
        border: 1px solid #edf0f5;
        max-width: 900px;
        margin: auto;
    }

    .form-header {
        margin-bottom: 25px;
    }

    .form-header h2 {
        margin: 0 0 6px;
        font-size: 22px;
    }

    .form-header p {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    .alasan-box {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .alasan-box strong {
        display: block;
        margin-bottom: 6px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        font-size: 13px;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        font-family: inherit;
        font-size: 14px;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
    }

    textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .current-file {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 10px;
        font-size: 13px;
    }

    .current-file a {
        color: #2563eb;
        font-weight: bold;
        text-decoration: none;
    }

    .current-file a:hover {
        text-decoration: underline;
    }

    .button-area {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn {
        border: none;
        border-radius: 7px;
        padding: 11px 18px;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .error-box {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error-box ul {
        margin: 5px 0 0;
        padding-left: 20px;
    }
</style>
@endpush

@section('content')

<div class="form-container">

    <div class="form-header">
        <h2>Perbaiki Dokumen</h2>
        <p>
            Perbaiki data atau ganti file dokumen yang ditolak,
            kemudian kirim kembali untuk diverifikasi.
        </p>
    </div>

    {{-- ALASAN PENOLAKAN --}}
    @if($dokumen->alasan_penolakan)
        <div class="alasan-box">
            <strong>⚠️ Alasan Penolakan:</strong>
            {{ $dokumen->alasan_penolakan }}
        </div>
    @endif

    {{-- ERROR VALIDASI --}}
    @if($errors->any())
        <div class="error-box">
            <strong>Periksa kembali data berikut:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('dokumens.updatePerbaikan', $dokumen) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PATCH')

        {{-- KLASTER --}}
        <div class="form-group">

            <label for="klaster_id">
                Klaster
            </label>

            <select
                name="klaster_id"
                id="klaster_id"
                class="form-control"
                required
            >

                <option value="">
                    Pilih Klaster
                </option>

                @foreach($klasters as $klaster)

                    <option
                        value="{{ $klaster->id }}"
                        {{ old('klaster_id', $dokumen->klaster_id) == $klaster->id ? 'selected' : '' }}
                    >
                        {{ $klaster->kode_klaster }} -
                        {{ $klaster->nama_klaster }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- PROGRAM --}}
        <div class="form-group">

            <label for="program_id">
                Program
            </label>

            <select
                name="program_id"
                id="program_id"
                class="form-control"
                required
            >

                <option value="">
                    Pilih Program
                </option>

                @foreach($programs as $program)

                    <option
                        value="{{ $program->id }}"
                        data-klaster="{{ $program->klaster_id }}"
                        {{ old('program_id', $dokumen->program_id) == $program->id ? 'selected' : '' }}
                    >
                        {{ $program->kode_program }} -
                        {{ $program->nama_program }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- JENIS DOKUMEN --}}
        <div class="form-group">

            <label for="jenis_dokumen_id">
                Jenis Dokumen
            </label>

            <select
                name="jenis_dokumen_id"
                id="jenis_dokumen_id"
                class="form-control"
                required
            >

                <option value="">
                    Pilih Jenis Dokumen
                </option>

                @foreach($jenisDokumens as $jenis)

                    <option
                        value="{{ $jenis->id }}"
                        {{ old('jenis_dokumen_id', $dokumen->jenis_dokumen_id) == $jenis->id ? 'selected' : '' }}
                    >
                        {{ $jenis->nama_jenis }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- NAMA DOKUMEN --}}
        <div class="form-group">

            <label for="nama_dokumen">
                Nama Dokumen
            </label>

            <input
                type="text"
                name="nama_dokumen"
                id="nama_dokumen"
                class="form-control"
                value="{{ old('nama_dokumen', $dokumen->nama_dokumen) }}"
                required
            >

        </div>


        {{-- DESKRIPSI --}}
        <div class="form-group">

            <label for="deskripsi">
                Deskripsi
            </label>

            <textarea
                name="deskripsi"
                id="deskripsi"
                class="form-control"
            >{{ old('deskripsi', $dokumen->deskripsi) }}</textarea>

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
                class="form-control"
                value="{{ old('periode', $dokumen->periode) }}"
                placeholder="Contoh: Januari - Maret"
            >

        </div>


        {{-- TAHUN --}}
        <div class="form-group">

            <label for="tahun">
                Tahun
            </label>

            <input
                type="number"
                name="tahun"
                id="tahun"
                class="form-control"
                value="{{ old('tahun', $dokumen->tahun) }}"
                min="2000"
                max="2100"
                required
            >

        </div>


        {{-- FILE LAMA --}}
        <div class="form-group">

            <label>
                File Saat Ini
            </label>

            <div class="current-file">

                📄

                {{ $dokumen->nama_file }}

                &nbsp; | &nbsp;

                <a
                    href="{{ asset('storage/' . $dokumen->file_path) }}"
                    target="_blank"
                >
                    Lihat File
                </a>

            </div>

        </div>


        {{-- FILE BARU --}}
        <div class="form-group">

            <label for="file">
                Ganti File
            </label>

            <input
                type="file"
                name="file"
                id="file"
                class="form-control"
            >

            <small style="color:#6b7280;">
                Kosongkan jika file lama masih ingin digunakan.
                Maksimal 20 MB.
            </small>

        </div>


        {{-- BUTTON --}}
        <div class="button-area">

            <button
                type="submit"
                class="btn btn-primary"
            >
                🔄 Kirim Kembali untuk Verifikasi
            </button>

            <a
                href="/dokumens"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>


<script>

    const klaster = document.getElementById('klaster_id');
    const program = document.getElementById('program_id');

    function filterPrograms() {

        const klasterId = klaster.value;

        for (let i = 0; i < program.options.length; i++) {

            const option = program.options[i];

            if (option.value === '') {
                option.hidden = false;
                continue;
            }

            if (
                klasterId === '' ||
                option.dataset.klaster === klasterId
            ) {
                option.hidden = false;
            } else {
                option.hidden = true;
            }
        }

        const selected = program.options[program.selectedIndex];

        if (
            selected &&
            selected.value !== '' &&
            selected.hidden
        ) {
            program.value = '';
        }
    }

    klaster.addEventListener('change', filterPrograms);

    filterPrograms();

</script>

@endsection