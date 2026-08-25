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
        'clock_size',
        'enableClock',
        'enableText',
        'enableAnim',
        'enableInfo',
        'animType',
        'matrix_power',
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
        'matrix_power' => 'boolean',
        'schedule'     => 'array',
    ];
}
