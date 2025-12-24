<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Instruktur extends Model
{
    protected $table = 'instrukturs';
    protected $guarded = ['id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_instruktur');
    }

    public function pesertas(): HasMany
    {
        return $this->hasMany(Peserta::class, 'id_instruktur');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'id_instruktur');
    }

    public function instruktur_mapels(): HasMany
    {
        return $this->hasMany(InstrukturMapel::class, 'id_instruktur');
    }
    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class, 'id_instruktur');
    }
}
