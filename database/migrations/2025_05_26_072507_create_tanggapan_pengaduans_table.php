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
        Schema::create('tanggapan_pengaduans', function (Blueprint $table) {
            $table->id();

            // tambahkan field untuk impor dari tabel pengaduan
            $table->unsignedBigInteger('pengaduan_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('user_id')->nullable();

            // impor dari tabel lain
            $table->foreign('pengaduan_id')->references('id')->on('pengaduans')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('category_reports')->onDelete('cascade');

            // referensi ke tabel users, jika user dihapus, set null
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            // isi tabel
            $table->string('isi_tanggapan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapan_pengaduans');
    }
};
