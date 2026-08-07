<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamDigital extends Model
{
    use HasFactory;

    protected $fillable = [
        'running_text',
        'sub_text',
        'speed',
        'size',
        'enableClock',
        'enableText',
        'enableAnim',
        'animType',
    ];
}
