<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_dibayar' => 'datetime',
    ];
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group');
    }

    protected static function booted()
    {
        static::creating(function ($pembayaran) {
            // Jika jumlah_dibayar tidak diisi manual saat input, jalankan logika default
            if (empty($pembayaran->total_dibayar)) {

                // Kondisi 1: Jika ada id_group, ambil dari group -> mapel -> harga
                if ($pembayaran->id_group) {
                    // Pastikan di Model Group sudah ada relasi ke 'mapel'
                    $pembayaran->total_dibayar = $pembayaran->group->mapel->harga ?? 0;
                }
                // Kondisi 2: Jika tidak ada id_group, ambil dari peserta -> mapel -> harga
                elseif ($pembayaran->id_peserta) {
                    // Pastikan di Model Peserta sudah ada relasi ke 'mapel'
                    $pembayaran->total_dibayar = $pembayaran->peserta->mapel->harga ?? 0;
                } else {
                    $pembayaran->total_dibayar = 0; // Cadangan jika keduanya kosong
                }
            }
        });
    }
}
