<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowStockNotification;
use App\Models\Product;

class SendLowStockNotifications extends Command
{
    protected $signature = 'notify:low-stock';
    protected $description = 'Envoie un email pour les produits en stock critique';

    public function handle()
    {
        $lowStockProducts = Product::whereColumn('quantity', '<', 'quantity_alert')->get();

        if ($lowStockProducts->count() > 0) {
            $emailDestinataire = env('NOTIFICATION_EMAIL');

            foreach ($lowStockProducts as $product) {
                Mail::to($emailDestinataire)->send(new LowStockNotification($product));
                $this->info("📩 Email envoyé pour : " . $product->name);
            }
        } else {
            $this->info("✅ Aucun produit en stock critique.");
        }
    }
}
