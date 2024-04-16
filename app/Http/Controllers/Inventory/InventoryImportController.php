<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;

class InventoryImportController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xls,xlsx',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            foreach (array_slice($rows, 1) as $row) {
                Inventory::create([
                    'name' => $row[0],
                    'code' => $row[1],
                    'quantity' => $row[2],
                    'category' => $row[3],
                    'selling_price' => $row[4],
                    'tax' => $row[5],
                    'tax_type' => $row[6],
                    'category_id' => $row[7],
                    'unit_id' => $row[8],
                    'created_at' => $row[9],
                    'updated_at' => $row[10],
                    'stock_phy' => $row[11],
                    'user_id' => $row[12],
                ]);
            }

            return redirect()->route('inventory.index')->with('success', 'Data inventory has been imported!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
