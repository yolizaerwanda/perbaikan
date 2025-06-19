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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();

            // tambahkan kolom foreign dulu
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kategori_id');

            // referensi dari table lain
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kategori_id')->references('id')->on('category_reports');

            // isi utama
            $table->string('judul');
            $table->string('isi_pengaduan');
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'ditolak'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
