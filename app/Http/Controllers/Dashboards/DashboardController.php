<?php

namespace App\Http\Controllers\Dashboards;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->input('category');
        $stockStatus = $request->input('stock_status', 'all');
        $dateFilter = $request->input('date');

        $categories = Category::all();
        $products = Product::with('category');

        if ($selectedCategory) {
            $products->where('category_id', $selectedCategory);
        }

        if ($stockStatus == 'alert') {
            $products->whereColumn('quantity', '<', 'quantity_alert');
        } elseif ($stockStatus == 'available') {
            $products->whereColumn('quantity', '>=', 'quantity_alert');
        }

        if ($dateFilter) {
            $products->whereDate('updated_at', $dateFilter);
        }

        $stockTrends = Product::select('name', 'quantity')
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        $productDistribution = Product::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get();

        $nearAlertProducts = Product::whereColumn('quantity', '<=', DB::raw('quantity_alert + 5'))
            ->whereColumn('quantity', '>', 'quantity_alert')
            ->get();

        $detectedProducts = session('inventory', []);

        // ✅ Récupérer les détections depuis la session et trier par nombre de détections
        $detections = session('detections', []);
        arsort($detections); // Trie décroissant par nombre de détections

        $stockStatusChart = [
            'available' => Product::whereColumn('quantity', '>=', 'quantity_alert')->count(),
            'alert' => Product::whereColumn('quantity', '<', 'quantity_alert')->count()
        ];

        return view('dashboard', [
            'categories' => $categories,
            'products' => $products->get(),
            'selectedCategory' => $selectedCategory,
            'stockStatus' => $stockStatus,
            'dateFilter' => $dateFilter ?? '',
            'totalProducts' => Product::count(),
            'totalLowStock' => Product::whereColumn('quantity', '<', 'quantity_alert')->count(),
            'totalCriticalCategories' => Category::whereHas('products', function ($query) {
                $query->whereColumn('quantity', '<', 'quantity_alert');
            })->count(),
            'productDistribution' => $productDistribution,
            'stockTrends' => $stockTrends,
            'nearAlertProducts' => $nearAlertProducts,
            'detectedProducts' => $detectedProducts,
            'stockStatusChart' => $stockStatusChart,
            'detections' => $detections // ✅ Envoi des détections à la vue
        ]);
    }
}
