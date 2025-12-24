<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    protected $table = 'groups';
    protected $guarded = ['id'];

    public function pesertas(): HasMany
    {
        return $this->hasMany(Peserta::class, 'id_group');
    }

    public function instruktur(): BelongsTo
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function jadwalKursus(): HasMany
    {
        return $this->hasMany(Absen::class, 'id_group')->where('status', 1);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_group');
    }
}
