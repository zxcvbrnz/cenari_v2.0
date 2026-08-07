<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JamDigital;
use Illuminate\Http\JsonResponse;

class JamDigitalController extends Controller
{
    public function getData(): JsonResponse
    {
        // Ambil record pertama atau data default jika tabel kosong
        $config = JamDigital::first();

        if (!$config) {
            return response()->json([
                'runningText' => 'Selamat Datang di Jam Digital!',
                'subText'     => 'RTC OK',
                'speed'       => 35,
                'size'        => 1,
                'enableClock' => true,
                'enableText'  => true,
                'enableAnim'  => true,
                'animType'    => 1,
            ]);
        }

        return response()->json([
            'runningText' => $config->running_text ?? $config->runningText,
            'subText'     => $config->sub_text ?? $config->subText,
            'speed'       => (int) $config->speed,
            'size'        => (int) $config->size,
            'enableClock' => (bool) ($config->enableClock ?? true),
            'enableText'  => (bool) ($config->enableText ?? true),
            'enableAnim'  => (bool) ($config->enableAnim ?? true),
            'animType'    => (int) ($config->animType ?? 1),
        ]);
    }
}
