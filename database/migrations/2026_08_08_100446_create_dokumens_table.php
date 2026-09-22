<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
    $table->id();

    $table->foreignId('klaster_id')
          ->constrained('klasters')
          ->cascadeOnDelete();

    $table->foreignId('program_id')
          ->constrained('programs')
          ->cascadeOnDelete();

    $table->foreignId('jenis_dokumen_id')
          ->constrained('jenis_dokumens')
          ->cascadeOnDelete();

    $table->string('nama_dokumen');
    $table->text('deskripsi')->nullable();

    $table->string('periode')->nullable();
    $table->year('tahun');

    $table->string('nama_file');
    $table->string('file_path');
    $table->unsignedBigInteger('file_size')->nullable();
    $table->string('file_type')->nullable();

    $table->enum('status', [
        'draft',
        'menunggu_verifikasi',
        'terverifikasi',
        'ditolak'
    ])->default('menunggu_verifikasi');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
