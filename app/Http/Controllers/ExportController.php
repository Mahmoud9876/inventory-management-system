<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Product;
use App\Models\Category;

class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'produits.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $products = Product::with('category')->get();
        
        // ✅ Import des graphiques depuis la requête
        $chartsFromRequest = json_decode($request->input('charts'), true); 

        // ✅ Association des graphiques avec des titres
        $charts = [
            'Tendances des Stocks 📈' => $chartsFromRequest[0] ?? null,
            'Répartition des Produits 🗂️' => $chartsFromRequest[1] ?? null,
            'Produits Proches du Seuil d\'Alerte 🚨' => $chartsFromRequest[2] ?? null,
            'État du Stock ✅' => $chartsFromRequest[3] ?? null,
            'Produits Détectés 🎯' => $chartsFromRequest[4] ?? null,
            
        ];

        $pdf = Pdf::loadView('exports.dashboard-pdf', [
            'products' => $products,
            'charts' => $charts,
            'totalProducts' => Product::count(),
            'totalLowStock' => Product::whereColumn('quantity', '<', 'quantity_alert')->count(),
            'totalCriticalCategories' => Category::whereHas('products', function ($query) {
                $query->whereColumn('quantity', '<', 'quantity_alert');
            })->count(),
            'isPdf' => true  // ✅ Indique qu'on est dans le PDF
        ]);

        return $pdf->download('rapport_inventaire.pdf');
    }
}
