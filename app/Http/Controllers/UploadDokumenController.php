<?php

namespace App\Http\Controllers;

use App\Models\Klaster;
use App\Models\Program;
use App\Models\JenisDokumen;
use App\Models\Dokumen;
use App\Models\RiwayatDokumen;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UploadDokumenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Ambil Semua Program
    |--------------------------------------------------------------------------
    */

    private function programYangBolehDiakses()
    {
        return Program::orderBy('klaster_id')
            ->orderBy('id')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi Program dan Klaster
    |--------------------------------------------------------------------------
    |
    | Semua user boleh memilih seluruh program.
    | Validasi ini hanya memastikan program memang berada
    | pada klaster yang dipilih.
    |
    */

    private function validasiProgramUser(
        $programId,
        $klasterId,
        $fail
    ) {
        $program = Program::find($programId);

        if (!$program) {
            $fail('Program yang dipilih tidak valid.');
            return;
        }

        if ($program->klaster_id != $klasterId) {
            $fail('Program yang dipilih tidak sesuai dengan Klaster.');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Keamanan File Upload
    |--------------------------------------------------------------------------
    */

    private function validasiKeamananFile($file): void
    {
        if (!$file || !$file->isValid()) {
            throw ValidationException::withMessages([
                'file' => 'File gagal diupload. Silakan pilih file kembali.',
            ]);
        }

        $allowedExtensions = [
            'pdf',
            'doc',
            'docx',
            'xls',
            'xlsx',
            'ppt',
            'pptx',
            'jpg',
            'jpeg',
            'png',
        ];

        $dangerousExtensions = [
            'php',
            'php3',
            'php4',
            'php5',
            'phtml',
            'phar',
            'exe',
            'com',
            'bat',
            'cmd',
            'sh',
            'bash',
            'ps1',
            'js',
            'mjs',
            'html',
            'htm',
            'svg',
            'jar',
            'msi',
            'scr',
            'vbs',
            'vb',
            'wsf',
            'hta',
        ];

        $originalName = $file->getClientOriginalName();
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            throw ValidationException::withMessages([
                'file' => 'Jenis file tidak diizinkan.',
            ]);
        }

        /*
        | Tolak nama file yang menyisipkan ekstensi script/executable
        | sebelum ekstensi akhir, contoh: laporan.php.pdf.
        */
        $parts = preg_split('/\./', strtolower($originalName));

        if (count($parts) > 2) {
            $extensionsBeforeLast = array_slice($parts, 1, -1);

            foreach ($extensionsBeforeLast as $part) {
                if (in_array($part, $dangerousExtensions, true)) {
                    throw ValidationException::withMessages([
                        'file' => 'Nama file terdeteksi tidak aman. Ubah nama file lalu upload kembali.',
                    ]);
                }
            }
        }

        /*
        | Karakter kontrol dan path separator tidak boleh ada
        | pada nama file asli.
        */
        if (
            preg_match('/[\x00-\x1F\x7F]/', $originalName) ||
            str_contains($originalName, '/') ||
            str_contains($originalName, '\\')
        ) {
            throw ValidationException::withMessages([
                'file' => 'Nama file tidak valid.',
            ]);
        }
    }


    private function namaFileAman($file): string
    {
        $originalName = $file->getClientOriginalName();

        $baseName = pathinfo(
            $originalName,
            PATHINFO_FILENAME
        );

        $extension = strtolower(
            $file->getClientOriginalExtension()
        );

        /*
        | Nama asli hanya disimpan sebagai metadata/tampilan.
        | File fisik tetap disimpan Laravel dengan nama acak.
        */
        $baseName = preg_replace(
            '/[^\pL\pN\-_ .()]/u',
            '_',
            $baseName
        );

        $baseName = trim($baseName, " .\t\n\r\0\x0B");

        if ($baseName === '') {
            $baseName = 'dokumen';
        }

        $baseName = mb_substr(
            $baseName,
            0,
            200
        );

        return $baseName . '.' . $extension;
    }


    private function mimeTypeFile($file): string
    {
        return $file->getMimeType()
            ?: $file->getClientMimeType()
            ?: 'application/octet-stream';
    }


    /*
    |--------------------------------------------------------------------------
    | Form Upload
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $programs = $this->programYangBolehDiakses();

        $klasters = Klaster::orderBy('id')->get();

        $jenisDokumens = JenisDokumen::orderBy('id')->get();

        return view(
            'dokumens.create',
            compact(
                'klasters',
                'programs',
                'jenisDokumens'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Dokumen Baru
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'klaster_id' => [
                'required',
                'exists:klasters,id',
            ],

            'program_id' => [
                'required',
                'exists:programs,id',

                function ($attribute, $value, $fail) use ($request) {
                    $this->validasiProgramUser(
                        $value,
                        $request->klaster_id,
                        $fail
                    );
                },
            ],

            'jenis_dokumen_id' => [
                'required',
                'exists:jenis_dokumens,id',
            ],

            'nama_dokumen' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'periode' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tahun' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'file' => [
                'required',
                'file',
                'max:512000',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan File
        |--------------------------------------------------------------------------
        */

        $file = $request->file('file');

        $this->validasiKeamananFile($file);

        $filePath = $file->store(
            'dokumen',
            'local'
        );


        /*
        |--------------------------------------------------------------------------
        | Simpan Data Dokumen
        |--------------------------------------------------------------------------
        */

        $dokumen = Dokumen::create([
            'user_id' => auth()->id(),

            'klaster_id' =>
                $validated['klaster_id'],

            'program_id' =>
                $validated['program_id'],

            'jenis_dokumen_id' =>
                $validated['jenis_dokumen_id'],

            'nama_dokumen' =>
                $validated['nama_dokumen'],

            'deskripsi' =>
                $validated['deskripsi'] ?? null,

            'periode' =>
                $validated['periode'] ?? null,

            'tahun' =>
                $validated['tahun'],

            'nama_file' =>
                $this->namaFileAman($file),

            'file_path' =>
                $filePath,

            'file_size' =>
                $file->getSize(),

            'file_type' =>
                $this->mimeTypeFile($file),

            'status' =>
                'menunggu_verifikasi',
        ]);
        /*
        |--------------------------------------------------------------------------
        | Buat Kode Dokumen Otomatis
        |--------------------------------------------------------------------------
        */

        $dokumen->kode_dokumen =
            'SKL-' .
            $dokumen->tahun .
            '-' .
            str_pad(
                $dokumen->id,
                6,
                '0',
                STR_PAD_LEFT
            );

        $dokumen->save();

        /*
        |--------------------------------------------------------------------------
        | Catat Riwayat Upload
        |--------------------------------------------------------------------------
        */

        RiwayatDokumen::create([
            'dokumen_id' =>
                $dokumen->id,

            'user_id' =>
                auth()->id(),

            'aksi' =>
                'upload',

            'status_sebelum' =>
                null,

            'status_sesudah' =>
                'menunggu_verifikasi',

            'keterangan' =>
                'Dokumen diupload dan dikirim untuk verifikasi.',
        ]);

ActivityLogger::log(
    'upload_dokumen',
    'Mengupload dokumen: ' . $dokumen->nama_dokumen,
    $dokumen
);
        return redirect('/dokumens')
            ->with(
                'success',
                'Dokumen berhasil diupload.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Form Perbaikan Dokumen
    |--------------------------------------------------------------------------
    */

    public function perbaiki(Dokumen $dokumen)
    {
        /*
        | Pemilik dokumen atau admin yang dapat memperbaiki.
        */

        if (
            auth()->user()->role !== 'admin' &&
            $dokumen->user_id !== auth()->id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses untuk memperbaiki dokumen ini.'
            );
        }


        /*
        | Hanya dokumen yang ditolak yang dapat diperbaiki.
        */

        if ($dokumen->status !== 'ditolak') {
            abort(
                403,
                'Dokumen ini tidak dapat diperbaiki.'
            );
        }


        /*
        | Semua klaster dan program tersedia.
        */

        $programs = $this->programYangBolehDiakses();

        $klasters = Klaster::orderBy('id')->get();

        $jenisDokumens = JenisDokumen::orderBy('id')->get();


        return view(
            'dokumens.perbaiki',
            compact(
                'dokumen',
                'klasters',
                'programs',
                'jenisDokumens'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Simpan Perbaikan Dokumen
    |--------------------------------------------------------------------------
    */

    public function updatePerbaikan(
        Request $request,
        Dokumen $dokumen
    ) {
        /*
        | Pemilik dokumen atau admin yang dapat memperbaiki.
        */

        if (
            auth()->user()->role !== 'admin' &&
            $dokumen->user_id !== auth()->id()
        ) {
            abort(
                403,
                'Anda tidak memiliki akses untuk memperbaiki dokumen ini.'
            );
        }


        /*
        | Pastikan status dokumen ditolak.
        */

        if ($dokumen->status !== 'ditolak') {
            abort(
                403,
                'Dokumen ini tidak dapat diperbaiki.'
            );
        }


        /*
        | Simpan status sebelum perubahan.
        */

        $statusSebelum = $dokumen->status;


        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'klaster_id' => [
                'required',
                'exists:klasters,id',
            ],

            'program_id' => [
                'required',
                'exists:programs,id',

                function ($attribute, $value, $fail) use ($request) {
                    $this->validasiProgramUser(
                        $value,
                        $request->klaster_id,
                        $fail
                    );
                },
            ],

            'jenis_dokumen_id' => [
                'required',
                'exists:jenis_dokumens,id',
            ],

            'nama_dokumen' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'periode' => [
                'nullable',
                'string',
                'max:100',
            ],

            'tahun' => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
            ],

            'file' => [
                'nullable',
                'file',
                'max:512000',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Data Perbaikan
        |--------------------------------------------------------------------------
        */

        $data = [
            'klaster_id' =>
                $validated['klaster_id'],

            'program_id' =>
                $validated['program_id'],

            'jenis_dokumen_id' =>
                $validated['jenis_dokumen_id'],

            'nama_dokumen' =>
                $validated['nama_dokumen'],

            'deskripsi' =>
                $validated['deskripsi'] ?? null,

            'periode' =>
                $validated['periode'] ?? null,

            'tahun' =>
                $validated['tahun'],

            'status' =>
                'menunggu_verifikasi',

            'alasan_penolakan' =>
                null,
        ];


        /*
        |--------------------------------------------------------------------------
        | Jika File Diganti
        |--------------------------------------------------------------------------
        */

        $fileDiganti = false;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $this->validasiKeamananFile($file);

            /*
            | Simpan file baru terlebih dahulu.
            */

            $filePath = $file->store(
                'dokumen',
                'local'
            );

            /*
            | Hapus file lama setelah file baru berhasil disimpan.
            */

            if (
                $dokumen->file_path &&
                Storage::disk('local')->exists(
                    $dokumen->file_path
                )
            ) {
                Storage::disk('local')->delete(
                    $dokumen->file_path
                );
            }

            $data['nama_file'] =
                $this->namaFileAman($file);

            $data['file_path'] =
                $filePath;

            $data['file_size'] =
                $file->getSize();

            $data['file_type'] =
                $this->mimeTypeFile($file);

            $fileDiganti = true;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Dokumen
        |--------------------------------------------------------------------------
        */

        $dokumen->update($data);


        /*
        |--------------------------------------------------------------------------
        | Catat Riwayat Perbaikan
        |--------------------------------------------------------------------------
        */

        RiwayatDokumen::create([
            'dokumen_id' =>
                $dokumen->id,

            'user_id' =>
                auth()->id(),

            'aksi' =>
                'diperbaiki',

            'status_sebelum' =>
                $statusSebelum,

            'status_sesudah' =>
                'menunggu_verifikasi',

            'keterangan' =>
                $fileDiganti
                    ? 'Dokumen diperbaiki, file diganti, dan dikirim kembali untuk verifikasi.'
                    : 'Dokumen diperbaiki dan dikirim kembali untuk verifikasi.',
        ]);

ActivityLogger::log(
    'perbaikan_dokumen',
    'Memperbaiki dokumen: ' . $dokumen->nama_dokumen,
    $dokumen
);

        return redirect('/dokumens')
            ->with(
                'success',
                'Dokumen berhasil diperbaiki dan dikirim kembali untuk verifikasi.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Download
    |--------------------------------------------------------------------------
    */

    public function download(Dokumen $dokumen)
    {
        /*
        | Semua user yang sudah login dapat mengakses file.
        */

        if (
            !Storage::disk('local')->exists(
                $dokumen->file_path
            )
        ) {
            abort(
                404,
                'File tidak ditemukan.'
            );
        }


        return Storage::disk('local')->download(
            $dokumen->file_path,
            $dokumen->nama_file
        );
    }
}