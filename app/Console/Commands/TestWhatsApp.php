<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestWhatsApp extends Command
{
    protected $signature = 'test:whatsapp';
    protected $description = 'Tester l\'envoi de messages WhatsApp via Meta API';

    public function handle()
    {
        $phoneId = env('WHATSAPP_PHONE_ID');
        $accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $recipient = "+212673427690";
        $message = "Test WhatsApp depuis Laravel avec SSL désactivé 🚀";

        $url = "https://graph.facebook.com/v17.0/{$phoneId}/messages";

        try {
            $response = Http::withOptions(['verify' => false]) // Désactive la vérification SSL
                ->withHeaders([
                    'Authorization' => "Bearer $accessToken",
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'messaging_product' => 'whatsapp',
                    'to' => $recipient,
                    'type' => 'text',
                    'text' => ['body' => $message]
                ]);

            $this->info("📤 Message envoyé, réponse API:");
            $this->info(json_encode($response->json(), JSON_PRETTY_PRINT));

        } catch (\Exception $e) {
            $this->error("❌ Erreur lors de l'envoi : " . $e->getMessage());
        }
    }
}
