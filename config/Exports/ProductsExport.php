<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::select('name', 'quantity', 'quantity_alert', 'category_id')->get();
    }

    public function headings(): array
    {
        return ["Nom du Produit", "Quantité", "Seuil d'Alerte", "ID Catégorie"];
    }
}
