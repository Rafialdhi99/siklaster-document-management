<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Throwable;

class BackupController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Folder Backup
    |--------------------------------------------------------------------------
    */

    private function backupPath(): string
    {
        return storage_path('app/private/backups');
    }


    /*
    |--------------------------------------------------------------------------
    | Halaman Backup
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $backupPath = $this->backupPath();

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $backups = collect(File::files($backupPath))
            ->filter(function ($file) {
                return strtolower($file->getExtension()) === 'sql';
            })
            ->map(function ($file) {
                return [
                    'nama' => $file->getFilename(),
                    'ukuran' => $file->getSize(),
                    'dibuat_pada' => $file->getMTime(),
                ];
            })
            ->sortByDesc('dibuat_pada')
            ->values();

        return view(
            'backup.index',
            compact('backups')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Buat Backup Baru
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Folder Backup
            |--------------------------------------------------------------------------
            */

            $backupPath = $this->backupPath();

            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }


            /*
            |--------------------------------------------------------------------------
            | Database
            |--------------------------------------------------------------------------
            */

            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');


            if (!$database || !$username) {

                return redirect()
                    ->route('backup.index')
                    ->with(
                        'error',
                        'Konfigurasi database tidak lengkap.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | mysqldump XAMPP
            |--------------------------------------------------------------------------
            */

            $mysqldump = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

            if (!File::exists($mysqldump)) {

                return redirect()
                    ->route('backup.index')
                    ->with(
                        'error',
                        'mysqldump tidak ditemukan di XAMPP.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Nama Backup
            |--------------------------------------------------------------------------
            */

            $fileName =
                'siklaster_backup_' .
                now()->format('Y-m-d_H-i-s') .
                '.sql';

            $filePath =
                $backupPath .
                DIRECTORY_SEPARATOR .
                $fileName;


            /*
            |--------------------------------------------------------------------------
            | Command Windows
            |--------------------------------------------------------------------------
            |
            | Dibuat mengikuti command mysqldump yang sudah berhasil
            | dijalankan langsung melalui PowerShell.
            |
            */

            $command =
                '"' . $mysqldump . '"' .
                ' -u ' . escapeshellarg($username);


            /*
            |--------------------------------------------------------------------------
            | Password
            |--------------------------------------------------------------------------
            */

            if ($password !== null && $password !== '') {

                $command .=
                    ' -p' .
                    escapeshellarg($password);
            }


            /*
            |--------------------------------------------------------------------------
            | Opsi Backup
            |--------------------------------------------------------------------------
            */

            $command .=
                ' --single-transaction' .
                ' --routines' .
                ' --triggers' .
                ' --events' .
                ' --default-character-set=utf8mb4' .
                ' --result-file=' .
                escapeshellarg($filePath) .
                ' ' .
                escapeshellarg($database) .
                ' 2>&1';


            /*
            |--------------------------------------------------------------------------
            | Jalankan
            |--------------------------------------------------------------------------
            */

            $output = [];
            $exitCode = 0;

            exec(
                $command,
                $output,
                $exitCode
            );


            /*
            |--------------------------------------------------------------------------
            | Periksa Exit Code
            |--------------------------------------------------------------------------
            */

            if ($exitCode !== 0) {

                if (File::exists($filePath)) {
                    File::delete($filePath);
                }

                $error = implode(
                    PHP_EOL,
                    $output
                );

                if (trim($error) === '') {
                    $error =
                        'mysqldump berhenti dengan kode ' .
                        $exitCode . '.';
                }

                return redirect()
                    ->route('backup.index')
                    ->with(
                        'error',
                        'Backup database gagal: ' .
                        $error
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan File Ada
            |--------------------------------------------------------------------------
            */

            if (!File::exists($filePath)) {

                return redirect()
                    ->route('backup.index')
                    ->with(
                        'error',
                        'Proses selesai tetapi file SQL tidak ditemukan.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan File Tidak Kosong
            |--------------------------------------------------------------------------
            */

            if (File::size($filePath) <= 0) {

                File::delete($filePath);

                return redirect()
                    ->route('backup.index')
                    ->with(
                        'error',
                        'File backup SQL yang dihasilkan kosong.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Berhasil
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route('backup.index')
                ->with(
                    'success',
                    'Backup database berhasil dibuat: ' .
                    $fileName
                );

        } catch (Throwable $e) {

            return redirect()
                ->route('backup.index')
                ->with(
                    'error',
                    'Terjadi kesalahan saat membuat backup: ' .
                    $e->getMessage()
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Download Backup
    |--------------------------------------------------------------------------
    */

    public function download(string $file)
    {
        $fileName = basename($file);

        if (
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            ) !== 'sql'
        ) {
            abort(404);
        }

        $filePath =
            $this->backupPath() .
            DIRECTORY_SEPARATOR .
            $fileName;

        if (!File::exists($filePath)) {
            abort(404);
        }

        return response()->download(
            $filePath,
            $fileName,
            [
                'Content-Type' =>
                    'application/sql',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Backup
    |--------------------------------------------------------------------------
    */

    public function destroy(string $file)
    {
        $fileName = basename($file);

        if (
            strtolower(
                pathinfo(
                    $fileName,
                    PATHINFO_EXTENSION
                )
            ) !== 'sql'
        ) {
            abort(404);
        }

        $filePath =
            $this->backupPath() .
            DIRECTORY_SEPARATOR .
            $fileName;

        if (!File::exists($filePath)) {

            return redirect()
                ->route('backup.index')
                ->with(
                    'error',
                    'File backup tidak ditemukan.'
                );
        }

        File::delete($filePath);

        return redirect()
            ->route('backup.index')
            ->with(
                'success',
                'Backup berhasil dihapus.'
            );
    }
}