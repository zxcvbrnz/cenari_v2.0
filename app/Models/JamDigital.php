<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamDigital extends Model
{
    use HasFactory;

    protected $fillable = [
        'runningText',
        'subText',
        'speed',
        'size',
        'clockSize',
        'enableClock',
        'enableText',
        'enableAnim',
        'animType',
        'enableInfo',
        'webUrl',
        'contactInfo',
    ];

    protected $casts = [
        'speed'       => 'integer',
        'size'        => 'integer',
        'clockSize'   => 'integer',
        'enableClock' => 'boolean',
        'enableText'  => 'boolean',
        'enableAnim'  => 'boolean',
        'enableInfo'  => 'boolean',
        'animType'    => 'integer',
    ];
}
