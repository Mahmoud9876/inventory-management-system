<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Http\Requests\Inventory\StoreInventoryRequest;
use App\Http\Requests\Inventory\UpdateInventoryRequest;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Picqer\Barcode\BarcodeGeneratorHTML;


class InventoryController extends Controller
{

public function index()
{
    // Récupérer tous les produits
    $inventoryItems = Inventory::where("user_id", auth()->id())->get();

    // Calculer le total de la quantité de tous les produits
    $totalQuantity = $inventoryItems->sum('quantity');

    // Calculer le total du prix de tous les produits
    $totalPrice = $inventoryItems->sum(function ($item) {
        return $item->quantity * $item->selling_price;
    });

    return view('inventory.index', compact('inventoryItems', 'totalQuantity', 'totalPrice'));
}


    
    public function create(Request $request)
    {
        $categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
        $units = Unit::where("user_id", auth()->id())->get(['id', 'name']);

    

        return view('inventory.create', compact('categories', 'units'));

    }

    public function store(StoreInventoryRequest $request)
    {
        /**
         * Handle upload image
         */
        $image = "";
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image')->store('products', 'public');
        }

        Inventory::create([
            "code" => IdGenerator::generate([
                'table' => 'inventory',
                'field' => 'code',
                'length' => 4,
                'prefix' => 'PC'
            ]),

            'product_image'     => $image,
            'name'              => $request->name,
            'category_id'       => $request->category_id,
            'unit_id'           => $request->unit_id,
            'quantity'          => $request->quantity,
            'selling_price'     => $request->selling_price,
            'tax'               => $request->tax,
            //'tax_type'          => $request->tax_type,
            "user_id" => auth()->id(),
            "slug" => Str::slug($request->name, '-'),
            "uuid" => Str::uuid()
        ]);


        return to_route('inventory.index')->with('success', 'Product has been created!');
    }

    public function show($uuid)
    {
        $inventoryItem= Inventory::where("uuid", $uuid)->firstOrFail();
        // Generate a barcode
        $generator = new BarcodeGeneratorHTML();

        $barcode = $generator->getBarcode($inventoryItem->code, $generator::TYPE_CODE_128);

        return view('inventory.show', [
            'inventoryItem' => $inventoryItem,
            'barcode' => $barcode,
        ]);
    }

    public function edit($uuid)
    {
        $inventory = Inventory::where("uuid", $uuid)->firstOrFail();
        return view('inventory.edit', [
            'categories' => Category::where("user_id", auth()->id())->get(),
            'units' => Unit::where("user_id", auth()->id())->get(),
            'inventory' => $inventory ]);
    }

    public function update(UpdateInventoryRequest $request, $uuid)
{
    // Récupérer l'inventaire correspondant à l'UUID
    $inventory = Inventory::where("uuid", $uuid)->firstOrFail();
    
    // Mettre à jour les attributs de l'inventaire
    /*$inventory->update($request->except('product_image'));

    // Gérer la mise à jour de l'image du produit
    $image = $inventory->product_image;
    if ($request->hasFile('product_image')) {
        // Supprimer l'ancienne photo si elle existe
        if ($inventory->product_image) {
            unlink(public_path('storage/') . $inventory->product_image);
        }
        // Stocker la nouvelle image
        $image = $request->file('product_image')->store('products', 'public');
    }*/

    // Mettre à jour les autres attributs de l'inventaire
    $inventory->name = $request->name;
    $inventory->slug = Str::slug($request->name, '-');
    //$inventory->category_id = $request->category_id;
    $inventory->unit_id = $request->unit_id;
    $inventory->quantity = $request->quantity;
    $inventory->selling_price = $request->selling_price;
    $inventory->tax = $request->tax;
    // Assurez-vous de gérer la mise à jour de stock_phy si nécessaire
     $inventory->stock_phy = $request->stock_phy;

    // Sauvegarder les modifications
    $inventory->save();

    // Rediriger vers la page d'index de l'inventaire avec un message de succès
    return redirect()
        ->route('inventory.index')
        ->with('success', 'Inventory has been updated!');
}
        public function destroy($uuid)
    {
        $inventory = Inventory::where("uuid", $uuid)->firstOrFail();
        /**
         * Delete photo if exists.
         */
        if ($inventory->product_image) {
            // check if image exists in our file system
            if (file_exists(public_path('storage/') . $inventory->product_image)) {
                unlink(public_path('storage/') . $inventory->product_image);
            }
        }

        $inventory->delete();

        return redirect()
            ->route('inventory.index')
            ->with('success', 'Inventory has been deleted!');
    }

    

    public function genererRapport()
    {
        // Récupérer les données à inclure dans le rapport (par exemple, les articles de l'inventaire)
        $inventoryItems = Inventory::all();
    
        // Calculer le total de la quantité de tous les produits
        $totalQuantity = $inventoryItems->sum('quantity');
    
        // Calculer le total du prix de tous les produits
        $totalPrice = $inventoryItems->sum(function ($item) {
            return $item->quantity * $item->selling_price;
        });
    
        // Créer une instance de Dompdf
        $dompdf = new Dompdf();
    
        // Charger le contenu de la vue dans Dompdf
        $html = view('inventory.report', compact('inventoryItems', 'totalQuantity', 'totalPrice'))->render();
        $dompdf->loadHtml($html);
    
        // (Optionnel) Configurer les options de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);
    
        // Rendre le PDF
        $dompdf->render();
    
        // Générer le nom du fichier PDF
        $fileName = 'inventory_report_' . date('Y-m-d_H:i:s') . '.pdf';
    
        // Vous pouvez renvoyer le PDF à la vue pour l'affichage ou le téléchargement, ou simplement le télécharger directement
        return $dompdf->stream($fileName);
    }
    

}