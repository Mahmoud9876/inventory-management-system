<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    /**
     * Mettre à jour la quantité des produits détectés
     */
    public function updateInventory(Request $request)
    {
        $inventory = session('inventory', []);

        if (!$inventory) {
            return back()->with('error', 'Aucune détection trouvée.');
        }

        foreach ($inventory as $productName => $detectedQuantity) {
            $product = Product::where('name', $productName)->first();

            if ($product) {
                // ✅ Mise à jour de la quantité du produit existant
                $product->update(['quantity' => $detectedQuantity]);
            } else {
                // ✅ Création d'un nouveau produit si inexistant
                Product::create([
                    'name' => $productName,
                    'code' => rand(1000, 9999),
                    'quantity' => $detectedQuantity,
                    'quantity_alert' => 5, // Valeur par défaut
                    'category' => 'Non catégorisé', // Valeur par défaut
                ]);
            }
        }

        return back()->with('success', 'Stock mis à jour avec succès.');
    }
}
