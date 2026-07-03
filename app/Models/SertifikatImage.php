<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_peserta',
        'image',
    ];

    // relasi ke model Peserta
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
}
