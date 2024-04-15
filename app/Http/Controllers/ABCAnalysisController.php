<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ABCAnalysisController extends Controller
{
    public function index()
    {
        // Retrieve all products
        $products = Product::all();

        // Sort products by quantity in descending order
        $sortedProducts = $products->sortByDesc('quantity');

        // Calculate total quantity in storage
        $totalQuantity = $sortedProducts->sum('quantity');

        // Calculate cumulative percentage of quantity
        $cumulativePercentage = 0;
        foreach ($sortedProducts as $product) {
            $product->percentage = ($product->quantity / $totalQuantity) * 100;
            $product->cumulativePercentage = $cumulativePercentage += $product->percentage;
            // Determine ABC classification based on cumulative percentage
            if ($product->cumulativePercentage <= 70) {
                $product->classification = 'A';
            } elseif ($product->cumulativePercentage <= 90) {
                $product->classification = 'B';
            } else {
                $product->classification = 'C';
            }
        }
        return view('abc-analysis.index', compact('sortedProducts'));
    }
}

