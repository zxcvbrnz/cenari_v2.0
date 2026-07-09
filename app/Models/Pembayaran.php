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
            // Jika total_bayar tidak diisi manual saat input, jalankan logika default
            if (empty($pembayaran->total_bayar)) {

                $pembayaranSebelumnya = null;

                // 1. Cari pembayaran terakhir berdasarkan Group atau Peserta
                if ($pembayaran->id_group) {
                    $pembayaranSebelumnya = self::where('id_group', $pembayaran->id_group)
                        ->latest() // mengambil data berdasarkan created_at terbaru
                        ->first();
                } elseif ($pembayaran->id_peserta) {
                    $pembayaranSebelumnya = self::where('id_peserta', $pembayaran->id_peserta)
                        ->latest()
                        ->first();
                }

                // 2. Jalankan logika pengecekan
                if ($pembayaranSebelumnya && !empty($pembayaranSebelumnya->total_bayar)) {
                    // JIKA ADA PEMBAYARAN SEBELUMNYA: Ambil dari total_bayar data terakhir tersebut
                    $pembayaran->total_bayar = $pembayaranSebelumnya->total_bayar;
                } else {
                    // JIKA TIDAK ADA: Ambil dari harga mapel (Logika awal Anda)
                    if ($pembayaran->id_group) {
                        $pembayaran->total_bayar = $pembayaran->group->mapel->harga ?? 0;
                    } elseif ($pembayaran->id_peserta) {
                        $pembayaran->total_bayar = $pembayaran->peserta->mapel->harga ?? 0;
                    } else {
                        $pembayaran->total_bayar = 0;
                    }
                }
            }
        });
    }
}
