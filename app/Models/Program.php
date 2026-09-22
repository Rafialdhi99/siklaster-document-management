<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'klaster_id',
        'kode_program',
        'nama_program',
        'keterangan',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relasi Klaster
    |--------------------------------------------------------------------------
    */

    public function klaster()
    {
        return $this->belongsTo(Klaster::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Relasi Dokumen
    |--------------------------------------------------------------------------
    */

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function users()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}
}