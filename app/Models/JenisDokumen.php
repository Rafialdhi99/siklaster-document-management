<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_jenis',
        'nama_jenis',
        'keterangan',
    ];
}