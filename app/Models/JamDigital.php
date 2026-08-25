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
        'enable_clock',
        'enable_text',
        'enable_anim',
        'enable_info',
        'anim_type',
        'matrix_power',
        'schedule',
    ];

    protected $casts = [
        'speed'        => 'integer',
        'size'         => 'integer',
        'clock_size'   => 'integer',
        'anim_type'    => 'integer',
        'enable_clock' => 'boolean',
        'enable_text'  => 'boolean',
        'enable_anim'  => 'boolean',
        'enable_info'  => 'boolean',
        'matrix_power' => 'boolean',
        'schedule'     => 'array',
    ];
}