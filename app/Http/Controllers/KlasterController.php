<?php

namespace App\Http\Controllers;

use App\Models\Klaster;

class KlasterController extends Controller
{
    public function index()
    {
        $klasters = Klaster::orderBy('kode_klaster')->get();

        return view('klasters.index', compact('klasters'));
    }
}