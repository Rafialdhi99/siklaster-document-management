<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Klaster extends Model
{
    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
    public function programs()
{
    return $this->hasMany(Program::class);
}
}