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
}
