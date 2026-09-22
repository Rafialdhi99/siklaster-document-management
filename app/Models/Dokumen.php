<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_dokumen',
        'user_id',
        'klaster_id',
        'program_id',
        'jenis_dokumen_id',
        'nama_dokumen',
        'deskripsi',
        'periode',
        'tahun',
        'nama_file',
        'file_path',
        'file_size',
        'file_type',
        'status',
        'alasan_penolakan',
    ];


    /*
    |--------------------------------------------------------------------------
    | Pengunggah Dokumen
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Klaster
    |--------------------------------------------------------------------------
    */

    public function klaster()
    {
        return $this->belongsTo(Klaster::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Program
    |--------------------------------------------------------------------------
    */

    public function program()
    {
        return $this->belongsTo(Program::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Jenis Dokumen
    |--------------------------------------------------------------------------
    */

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Riwayat Dokumen
    |--------------------------------------------------------------------------
    |
    | Satu dokumen dapat memiliki banyak riwayat:
    | upload, ditolak, diperbaiki, diverifikasi, dan lain-lain.
    |
    */

    public function riwayats()
    {
        return $this->hasMany(RiwayatDokumen::class)
            ->orderBy('created_at', 'asc');
    }
}