<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absen extends Model
{
    protected $table = 'absens';
    protected $guarded = ['id'];
    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_absen' => 'datetime',
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class, 'id_peserta');
    }
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group');
    }
}
