<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TwilioWhatsApp
{
    public function send(?string $rawTo, string $body): bool
    {
        $sid   = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from  = env('TWILIO_WHATSAPP_FROM');

        $to = $this->formatWhatsAppNumber($rawTo);

        if (!$sid || !$token || !$from || !$to || trim($body) === '') {
            return false;
        }

        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post($url, [
                'From' => $from,
                'To'   => $to,
                'Body' => $body,
            ]);

        return $response->successful();
    }

    private function formatWhatsAppNumber(?string $raw): ?string
    {
        if (!$raw) {
            return null;
        }

        $default = env('DEFAULT_COUNTRY_CODE', '+233');
        $clean   = preg_replace('/\s+/', '', $raw);

        // Already has whatsapp: prefix
        if (Str::startsWith($clean, 'whatsapp:')) {
            return $clean;
        }

        // Remove non-digits except leading +
        $normalized = $clean;
        if (!Str::startsWith($normalized, '+')) {
            // If starts with 0, replace with default country code
            if (Str::startsWith($normalized, '0')) {
                $normalized = $default . ltrim($normalized, '0');
            } elseif (Str::startsWith($normalized, $default)) {
                $normalized = '+' . ltrim($normalized, '+');
            } else {
                $normalized = $default . $normalized;
            }
        }

        // Ensure starts with +
        if (!Str::startsWith($normalized, '+')) {
            $normalized = '+' . ltrim($normalized, '+');
        }

        return 'whatsapp:' . $normalized;
    }
}
