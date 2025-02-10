<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WhatsAppService;

class SendTestWhatsAppMessage extends Command
{
    protected $signature = 'test:whatsapp'; // Nom de la commande artisan
    protected $description = 'Envoie un message WhatsApp de test';

    public function handle()
    {
        $whatsappService = new WhatsAppService();
        $recipient = env('WHATSAPP_PHONE_NUMBER', '+212673427690'); // Remplace avec ton numéro si besoin
        $message = "🚀 Ceci est un message de test depuis Laravel !";

        $whatsappService->sendMessage($recipient, $message);

        $this->info("✅ Message WhatsApp envoyé à $recipient !");
    }
}
