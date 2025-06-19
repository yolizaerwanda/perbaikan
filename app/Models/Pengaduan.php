<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengaduan extends Model
{
    protected $fillable = [
        'judul',
        'isi_pengaduan',
        'kategori_id',
        'user_id',
        'status',
        'timestamp',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(CategoryReport::class, 'kategori_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tanggapan(): HasOne
    {
        return $this->hasOne(TanggapanPengaduan::class, 'pengaduan_id');
    }
}
