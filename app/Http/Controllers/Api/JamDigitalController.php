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
                'clockSize'   => 1,
                'enableClock' => true,
                'enableText'  => true,
                'enableAnim'  => true,
                'enableInfo'  => true,
                'animType'    => 1,
                'webUrl'      => 'cenari.sch.id',
                'contactInfo' => '081234567890',
            ]);
        }

        return response()->json([
            'runningText' => $config->running_text ?? $config->runningText,
            'subText'     => $config->sub_text ?? $config->subText,
            'speed'       => (int) $config->speed,
            'size'        => (int) $config->size,
            'clockSize'   => (int) ($config->clock_size ?? $config->clockSize ?? 1),
            'enableClock' => (bool) ($config->enable_clock ?? $config->enableClock ?? true),
            'enableText'  => (bool) ($config->enable_text ?? $config->enableText ?? true),
            'enableAnim'  => (bool) ($config->enable_anim ?? $config->enableAnim ?? true),
            'enableInfo'  => (bool) ($config->enable_info ?? $config->enableInfo ?? true),
            'animType'    => (int) ($config->anim_type ?? $config->animType ?? 1),
            'webUrl'      => $config->web_url ?? $config->webUrl ?? 'cenari.sch.id',
            'contactInfo' => $config->contact_info ?? $config->contactInfo ?? '081234567890',
        ]);
    }
}
