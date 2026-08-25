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
        'web_url',
        'contact_info',
        'speed',
        'size',
        'clockSize',
        'enableClock',
        'enableText',
        'enableAnim',
        'enableInfo',
        'animType',
        'matrixPower',
        'schedule',
    ];

    protected $casts = [
        'speed'        => 'integer',
        'size'         => 'integer',
        'clock_size'   => 'integer',
        'anim_type'    => 'integer',
        'enableClock' => 'boolean',
        'enableText'  => 'boolean',
        'enableAnim'  => 'boolean',
        'enableInfo'  => 'boolean',
        'matrixPower' => 'boolean',
        'schedule'     => 'array',
    ];
}
