<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User Penerima
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Dokumen Terkait
            |--------------------------------------------------------------------------
            */

            $table->foreignId('dokumen_id')
                ->nullable()
                ->constrained('dokumens')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Jenis Notifikasi
            |--------------------------------------------------------------------------
            |
            | Contoh:
            | ditolak
            | terverifikasi
            |
            */

            $table->string('jenis');


            /*
            |--------------------------------------------------------------------------
            | Isi Notifikasi
            |--------------------------------------------------------------------------
            */

            $table->string('judul');

            $table->text('pesan')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Status Dibaca
            |--------------------------------------------------------------------------
            */

            $table->boolean('dibaca')
                ->default(false);

            $table->timestamp('dibaca_pada')
                ->nullable();


            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Index
            |--------------------------------------------------------------------------
            */

            $table->index([
                'user_id',
                'dibaca'
            ]);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};