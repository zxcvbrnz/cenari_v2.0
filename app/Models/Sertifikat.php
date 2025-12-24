<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
