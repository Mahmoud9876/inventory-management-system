<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CallMeBotService
{
    public function sendMessage($message)
    {
        $phone = env('CALLMEBOT_PHONE');
        $apiKey = env('CALLMEBOT_API_KEY');

        $url = "https://api.callmebot.com/whatsapp.php?phone=$phone&text=" . urlencode($message) . "&apikey=$apiKey";

        // ✅ Désactiver la vérification SSL temporairement pour résoudre l'erreur
        $response = Http::withOptions(['verify' => false])->get($url);

        if ($response->successful()) {
            return [
                'status' => 'success',
                'message' => '✅ Message WhatsApp envoyé avec succès !',
                'response' => $response->json(),
            ];
        } else {
            return [
                'status' => 'error',
                'message' => '❌ Échec de l\'envoi du message.',
                'response' => $response->json(),
            ];
        }
    }
}
