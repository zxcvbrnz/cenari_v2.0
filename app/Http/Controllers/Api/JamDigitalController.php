<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JamDigital;
use Illuminate\Http\JsonResponse;

class JamDigitalController extends Controller
{
    public function getData(): JsonResponse
    {
        $config = JamDigital::first();

        // Template default schedule 7 hari
        $defaultSchedule = [
            ['enabled' => true,  'startHour' => 6, 'startMinute' => 0, 'endHour' => 22, 'endMinute' => 0],
            ['enabled' => true,  'startHour' => 6, 'startMinute' => 0, 'endHour' => 22, 'endMinute' => 0],
            ['enabled' => true,  'startHour' => 6, 'startMinute' => 0, 'endHour' => 22, 'endMinute' => 0],
            ['enabled' => true,  'startHour' => 6, 'startMinute' => 0, 'endHour' => 22, 'endMinute' => 0],
            ['enabled' => true,  'startHour' => 6, 'startMinute' => 0, 'endHour' => 22, 'endMinute' => 0],
            ['enabled' => true,  'startHour' => 6, 'startMinute' => 0, 'endHour' => 22, 'endMinute' => 0],
            ['enabled' => false, 'startHour' => 0, 'startMinute' => 0, 'endHour' => 0,  'endMinute' => 0],
        ];

        if (!$config) {
            return response()->json([
                'runningText' => 'Selamat Datang di Cenari Education Center',
                'subText'     => 'CENARI OK',
                'webUrl'      => 'cenari.sch.id',
                'contactInfo' => '081234567890',
                'speed'       => 35,
                'size'        => 1,
                'clockSize'   => 1,
                'enableClock' => true,
                'enableText'  => true,
                'enableAnim'  => true,
                'enableInfo'  => true,
                'animType'    => 1,
                'matrixPower' => true,
                'schedule'    => $defaultSchedule,
            ]);
        }

        return response()->json([
            'runningText' => $config->running_text,
            'subText'     => $config->sub_text,
            'webUrl'      => $config->webUrl ?? 'cenari.sch.id',
            'contactInfo' => $config->contactInfo ?? '081234567890',
            'speed'       => (int) $config->speed,
            'size'        => (int) $config->size,
            'clockSize'   => (int) $config->clock_size,
            'enableClock' => (bool) $config->enableClock,
            'enableText'  => (bool) $config->enableText,
            'enableAnim'  => (bool) $config->enableAnim,
            'enableInfo'  => (bool) $config->enableInfo,
            'animType'    => (int) $config->animType,
            'matrixPower' => (bool) $config->matrix_power,
            'schedule'    => $config->schedule ?? $defaultSchedule,
        ]);
    }
}
