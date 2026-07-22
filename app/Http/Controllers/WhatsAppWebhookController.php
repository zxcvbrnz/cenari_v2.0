<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    // Verification Endpoint untuk Meta Webhook Setup
    public function verify(Request $request)
    {
        $verifyToken = config('services.whatsapp.verify_token', 'my_secret_token');

        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

        if ($mode && $token) {
            if ($mode === 'subscribe' && $token === $verifyToken) {
                return response($challenge, 200);
            }
            return response()->json(['error' => 'Forbidden'], 403);
        }
    }

    // Menerima pesan masuk dari Meta
    public function handle(Request $request)
    {
        $data = $request->all();

        try {
            $entry = $data['entry'][0] ?? null;
            $changes = $entry['changes'][0] ?? null;
            $value = $changes['value'] ?? null;

            if (isset($value['messages'][0])) {
                $msgData = $value['messages'][0];
                $from = $msgData['from']; // Nomor pengirim
                $wamId = $msgData['id'];
                $text = '';

                if ($msgData['type'] === 'text') {
                    $text = $msgData['text']['body'];
                } else {
                    $text = '[Media / Non-text Message]';
                }

                // Simpan ke database
                Message::create([
                    'phone_number' => $from,
                    'direction'    => 'inbound',
                    'body'         => $text,
                    'wam_id'       => $wamId,
                    'status'       => 'received'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp Webhook Error: ' . $e->getMessage());
        }

        return response()->json(['status' => 'success'], 200);
    }
}