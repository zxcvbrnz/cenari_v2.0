<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Peserta extends Model
{
    protected $table = 'pesertas';
    protected $guarded = ['id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_peserta');
    }
    public function nilai(): HasOne
    {
        return $this->hasOne(Nilai::class, 'id_peserta');
    }

    public function instruktur(): BelongsTo
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function jadwalKursus(): HasMany
    {
        return $this->hasMany(Absen::class, 'id_peserta')->where('status', 1);
    }
    public function riwayatAbsensi(): HasMany
    {
        return $this->hasMany(Absen::class, 'id_peserta')->where('status', 2);
    }

    public function sertifikat(): HasOne
    {
        return $this->hasOne(Sertifikat::class, 'id_peserta');
    }
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_peserta');
    }
}