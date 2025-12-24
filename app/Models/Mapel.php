<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel extends Model
{
    protected $table = 'mapels';
    protected $guarded = ['id'];

    public function pesertas(): HasMany
    {
        return $this->hasMany(Peserta::class, 'id_mapel');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class, 'id_mapel');
    }

    public function instruktur_mapel(): HasMany
    {
        return $this->hasMany(InstrukturMapel::class, 'id_mapel');
    }
    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class, 'id_mapel');
    }
}
