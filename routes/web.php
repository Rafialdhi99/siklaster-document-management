<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KlasterController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\UploadDokumenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerifikasiDokumenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ArsipDokumenController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ActivityLogController;


/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| APLIKASI UTAMA SIKLASTER
|--------------------------------------------------------------------------
|
| Semua user yang sudah login dapat mengakses aplikasi utama.
|
*/

Route::middleware([
    'auth'
])->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Arsip Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/arsip', [
        ArsipDokumenController::class,
        'index'
    ])->name('arsip.index');


    Route::get('/arsip/klaster/{klaster}', [
        ArsipDokumenController::class,
        'klaster'
    ])->name('arsip.klaster');


    Route::get('/arsip/program/{program}', [
        ArsipDokumenController::class,
        'program'
    ])->name('arsip.program');


    Route::get('/arsip/program/{program}/tahun/{tahun}', [
        ArsipDokumenController::class,
        'tahun'
    ])->name('arsip.tahun');


    Route::get('/arsip/program/{program}/tahun/{tahun}/periode/{periode}', [
        ArsipDokumenController::class,
        'periode'
    ])->name('arsip.periode');


    /*
    |--------------------------------------------------------------------------
    | Klaster
    |--------------------------------------------------------------------------
    */

    Route::get('/klasters', [
        KlasterController::class,
        'index'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumens', [
        DokumenController::class,
        'index'
    ])->name('dokumens.index');


    Route::get('/dokumens/upload', [
        UploadDokumenController::class,
        'create'
    ]);


    Route::post('/dokumens/upload', [
        UploadDokumenController::class,
        'store'
    ]);


    Route::get('/dokumens/{dokumen}', [
        DokumenController::class,
        'show'
    ])->name('dokumens.show');


    /*
    |--------------------------------------------------------------------------
    | Preview Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumens/{dokumen}/preview', [
        DokumenController::class,
        'preview'
    ])->name('dokumens.preview');


    /*
    |--------------------------------------------------------------------------
    | Download Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumens/{dokumen}/download', [
        DokumenController::class,
        'download'
    ])->name('dokumens.download');


    /*
    |--------------------------------------------------------------------------
    | Perbaikan Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/dokumens/{dokumen}/perbaiki', [
        UploadDokumenController::class,
        'perbaiki'
    ])->name('dokumens.perbaiki');


    Route::patch('/dokumens/{dokumen}/perbaiki', [
        UploadDokumenController::class,
        'updatePerbaikan'
    ])->name('dokumens.updatePerbaikan');


    /*
    |--------------------------------------------------------------------------
    | Hapus Dokumen
    |--------------------------------------------------------------------------
    */

    Route::delete('/dokumens/{dokumen}', [
        DokumenController::class,
        'destroy'
    ])->name('dokumens.destroy');


    /*
    |--------------------------------------------------------------------------
    | Notifikasi
    |--------------------------------------------------------------------------
    */

    Route::get('/notifikasi', [
        NotifikasiController::class,
        'index'
    ])->name('notifikasi.index');


    Route::patch('/notifikasi/tandai-semua/dibaca', [
        NotifikasiController::class,
        'tandaiSemuaDibaca'
    ])->name('notifikasi.semua-dibaca');


    Route::patch('/notifikasi/{notifikasi}/dibaca', [
        NotifikasiController::class,
        'tandaiDibaca'
    ])->name('notifikasi.dibaca');


    Route::get('/notifikasi/{notifikasi}', [
        NotifikasiController::class,
        'show'
    ])->name('notifikasi.show');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');


    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');


    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| FITUR KHUSUS ADMIN
|--------------------------------------------------------------------------
|
| Hanya akun dengan role admin yang dapat mengakses bagian ini.
|
*/

Route::middleware([
    'auth',
    'role:admin'
])->group(function () {

/*
|--------------------------------------------------------------------------
| SAMPAH DOKUMEN
|--------------------------------------------------------------------------
*/

Route::get('/dokumens-sampah', [
    DokumenController::class,
    'sampah'
])->name('dokumens.sampah');

Route::patch('/dokumens-sampah/{id}/restore', [
    DokumenController::class,
    'restore'
])->name('dokumens.restore');

Route::delete('/dokumens-sampah/{id}/force-delete', [
    DokumenController::class,
    'forceDelete'
])->name('dokumens.force-delete');


    /*
    |--------------------------------------------------------------------------
    | Verifikasi Dokumen
    |--------------------------------------------------------------------------
    */

    Route::get('/verifikasi', [
        VerifikasiDokumenController::class,
        'index'
    ])->name('verifikasi.index');


    Route::get('/verifikasi/riwayat', [
        VerifikasiDokumenController::class,
        'riwayat'
    ])->name('verifikasi.riwayat');


    Route::patch('/verifikasi/{dokumen}/setujui', [
        VerifikasiDokumenController::class,
        'setujui'
    ])->name('verifikasi.setujui');


    Route::patch('/verifikasi/{dokumen}/tolak', [
        VerifikasiDokumenController::class,
        'tolak'
    ])->name('verifikasi.tolak');

    Route::get('/activity-logs', [
    ActivityLogController::class,
    'index'
])->name('activity-logs.index');


    /*
    |--------------------------------------------------------------------------
    | Pengguna
    |--------------------------------------------------------------------------
    */

    Route::get('/users', [
        UserController::class,
        'index'
    ])->name('users.index');


    Route::get('/users/create', [
        UserController::class,
        'create'
    ])->name('users.create');


    Route::post('/users', [
        UserController::class,
        'store'
    ])->name('users.store');


    Route::get('/users/{user}/edit', [
        UserController::class,
        'edit'
    ])->name('users.edit');


    Route::patch('/users/{user}', [
        UserController::class,
        'update'
    ])->name('users.update');


    Route::delete('/users/{user}', [
        UserController::class,
        'destroy'
    ])->name('users.destroy');


    /*
|--------------------------------------------------------------------------
| Backup Database
|--------------------------------------------------------------------------
*/

Route::get('/backup', [
    BackupController::class,
    'index'
])->name('backup.index');


Route::post('/backup', [
    BackupController::class,
    'store'
])->name('backup.store');


Route::get('/backup/{file}/download', [
    BackupController::class,
    'download'
])->name('backup.download');


Route::delete('/backup/{file}', [
    BackupController::class,
    'destroy'
])->name('backup.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';