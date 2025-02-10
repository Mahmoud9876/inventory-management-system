<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StockController extends Controller
{
    /**
     * Afficher la gestion du stock.
     */
    public function index()
    {
        $products = Product::all();
        return view('stock.index', compact('products'));
    }

    /**
     * Mettre à jour le stock minimum d’un produit.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stock_min' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $product->update(['stock_min' => $request->stock_min]);

        return redirect()->route('stock.index')->with('success', "Stock mis à jour !");
    }
}


