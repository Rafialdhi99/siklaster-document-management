<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokumen_id',
        'user_id',
        'aksi',
        'status_sebelum',
        'status_sesudah',
        'keterangan',
    ];

    public function dokumen()
    {
        return $this->belongsTo(Dokumen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}