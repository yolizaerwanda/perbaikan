<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TanggapanPengaduan extends Model
{
    protected $fillable = [
        'pengaduan_id',
        'kategori_id',
        'user_id',
        'isi_tanggapan',
    ];

    public function pengaduan(): BelongsTo
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(CategoryReport::class, 'kategori_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
