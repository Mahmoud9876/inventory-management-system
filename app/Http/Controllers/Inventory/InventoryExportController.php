<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryExportController extends Controller
{
    public function create()
    {
        $inventoryItems = Inventory::all()->sortBy('name');

        $inventoryArray[] = array(
            'Name',
            'Code',
            'Quantity',
            'Category',
            'Selling Price',
            'Tax',
            'Tax Type',
            'Category ID',
            'Unit ID',
            'Created At',
            'Updated At',
            'Physical Stock',
            'User ID',
        );

        foreach ($inventoryItems as $item) {
            $inventoryArray[] = array(
                'Name' => $item->name,
                'Code' => $item->code,
                'Quantity' => $item->quantity,
                'Category' => $item->category,
                'Selling Price' => $item->selling_price,
                'Tax' => $item->tax,
                'Tax Type' => $item->tax_type,
                'Category ID' => $item->category_id,
                'Unit ID' => $item->unit_id,
                'Created At' => $item->created_at,
                'Updated At' => $item->updated_at,
                'Physical Stock' => $item->stock_phy,
                'User ID' => $item->user_id,
            );
        }

        $this->store($inventoryArray);
    }
}