<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    protected $table = 'materis';
    protected $guarded = ['id'];

    public function instruktur(): BelongsTo
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur');
    }
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
