<?php
namespace App\Http\Controllers;
use App\Http\Requests\Contract\ContractStoreRequest;
use App\Http\Requests\Contracts\ContractsStoreRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Contracts;
use App\Models\Product;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;

use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Str;
class ContractsController extends Controller
{
    public function index()
    {
        $contracts = Contracts::all();
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $products = Product::where("user_id", auth()->id())->get(['id', 'name']);
        $suppliers = Supplier::where("user_id", auth()->id())->get(['id', 'name']);
        return view('contracts.create', [
            'products' => $products,
            'suppliers' => $suppliers,
        ]);
    }
    public function store(ContractsStoreRequest $request)
    {
        $contract = Contracts::create([
            'supplier_id' => $request->supplier_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'product_id' => $request->product_id,
            'payment_terms' => $request->payment_terms,
            'ordered_quantity' => $request->ordered_quantity,
            'unit_price' => $request->unit_price,
            'contract_terms' => $request->contract_terms,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_id' => auth()->id(),
            
        ]);
    
        return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
    }
    
    public function show($id)
    {
        $contract = Contracts::find($id);
        return view('contracts.show', compact('contract'));
    }

    public function edit($id)
    {
        $contract = Contracts::findOrFail($id);
        return view('contracts.edit', compact('contract'));
    }
    

    
    public function update(Request $request, $id)
    {

        $contract = Contracts::findOrFail($id);
        $contract->update($request->all());

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
    }

    public function destroy($id)
    {
        $contract = Contracts::findOrFail($id);
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
    }
    public function pdf($id)
    {
        // Get the contract data
        $contract = Contracts::findOrFail($id);
    
        // Create a new instance of Dompdf
        $dompdf = new Dompdf();
    
        // Load the PDF view with contract data
        $html = view('contracts.pdf', compact('contract'))->render();
    
        // Set options for the PDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
    
        // Apply options to Dompdf
        $dompdf->setOptions($options);
    
        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);
    
        // Render the PDF
        $dompdf->render();
    
        // Stream the PDF
        return $dompdf->stream("contract_$id.pdf");
    }
}
    
