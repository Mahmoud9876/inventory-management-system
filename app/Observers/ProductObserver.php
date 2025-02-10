<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\CallMeBotService;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;

class ProductObserver
{
    public function updated(Product $product)
    {
        // ✅ Vérifie si la quantité a été modifiée
        if ($product->wasChanged('quantity')) {
            // 🚨 Si le stock est inférieur au seuil critique
            if ($product->quantity < $product->quantity_alert) {

                // 📩 Envoi d'un email (déjà implémenté)
                $email = env('NOTIFICATION_EMAIL');
                if ($email) {
                    Mail::to($email)->send(new LowStockNotification($product));
                }

                // 📲 Envoi d'une notification WhatsApp
                $whatsAppService = new CallMeBotService();
                $message = "🚨 *Alerte Stock Bas* 🚨\n\n" .
                           "📦 *Produit :* {$product->name}\n" .
                           "🔢 *Quantité actuelle :* {$product->quantity}\n" .
                           "⚠️ *Seuil critique :* {$product->quantity_alert}\n" .
                           "📊 *Catégorie :* {$product->category->name}";

                $whatsAppService->sendMessage($message);
            }
        }
    }
}
