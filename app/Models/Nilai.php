<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $primaryKey = 'id_peserta';

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
