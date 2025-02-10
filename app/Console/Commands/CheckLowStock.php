<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckLowStock extends Command
{
    protected $signature = 'check:low-stock';
    protected $description = 'Vérifie les produits en rupture de stock et envoie une alerte';

    public function handle()
    {
        $lowStockProducts = Product::whereColumn('quantity', '<', 'quantity_alert')->get();

        if ($lowStockProducts->count() > 0) {
            Log::info("🚨 Produits en alerte détectés !");
            
            foreach ($lowStockProducts as $product) {
                $emailDestinataire = env('NOTIFICATION_EMAIL');

                if ($emailDestinataire) {
                    Mail::to($emailDestinataire)->send(new LowStockNotification($product));
                    Log::info("📩 Email envoyé pour le produit : " . $product->name);
                }
            }
        } else {
            Log::info("✅ Aucun produit en alerte.");
        }
    }
}

