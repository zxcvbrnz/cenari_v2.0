<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected string $token;
    protected string $phoneId;
    protected string $baseUrl;

    public function __construct()
    {
        // Mengambil kredensial dari file config/services.php
        $this->token = config('services.whatsapp.token') ?? env('WHATSAPP_TOKEN');
        $this->phoneId = config('services.whatsapp.phone_number_id') ?? env('WHATSAPP_PHONE_NUMBER_ID');
        $this->baseUrl = "https://graph.facebook.com/v25.0/{$this->phoneId}/messages";
    }

    /**
     * Normalisasi nomor HP ke format internasional WhatsApp (628xxx)
     */
    private function formatNumber(string $number): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);

        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    /**
     * Mengirim pesan teks biasa (Hanya berfungsi jika ada interaksi dalam 24 jam)
     */
    public function sendText(string $to, string $message): bool
    {
        try {
            $response = Http::withToken($this->token)
                ->post($this->baseUrl, [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $this->formatNumber($to),
                    'type' => 'text',
                    'text' => [
                        'body' => $message
                    ]
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('WhatsApp API Gagal (Teks): ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mengirim pesan berbasis Template (Wajib untuk pesan pertama/notifikasi blast)
     */
    public function sendTemplate(string $to, string $templateName, array $parameters = [], string $language = 'id'): bool
    {
        $components = [];
        if (!empty($parameters)) {
            $paramsFormatted = array_map(function ($value) {
                return ['type' => 'text', 'text' => (string) $value];
            }, $parameters);

            $components[] = [
                'type' => 'body',
                'parameters' => $paramsFormatted
            ];
        }

        try {
            $response = Http::withToken($this->token)
                ->post($this->baseUrl, [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $this->formatNumber($to),
                    'type' => 'template',
                    'template' => [
                        'name' => $templateName,
                        'language' => ['code' => $language],
                        'components' => $components
                    ]
                ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('WhatsApp API Gagal (Template): ' . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp Exception: ' . $e->getMessage());
            return false;
        }
    }
}
