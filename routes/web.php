<?php
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Order\DueOrderController;
use App\Http\Controllers\Order\OrderCompleteController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderPendingController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductExportController;
use App\Http\Controllers\Product\ProductImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Quotation\QuotationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Inventory\InventoryController;
use App\Http\Controllers\Inventory\InventoryExportController;
use App\Http\Controllers\Inventory\InventoryImportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GrandLivreController;
use App\Http\Controllers\ABCAnalysisController;
use App\Http\Controllers\Detection\DetectionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('php/', function () {
    return phpinfo();
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
     Route::resource('/users', UserController::class); //->except(['show']);
    Route::put('/user/change-password/{username}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::get('/profile/store-settings', [ProfileController::class, 'store_settings'])->name('profile.store.settings');
    Route::post('/profile/store-settings', [ProfileController::class, 'store_settings_store'])->name('profile.store.settings.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/quotations', QuotationController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/suppliers', SupplierController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/units', UnitController::class);

    // Route Products
    Route::get('products/import/', [ProductImportController::class, 'create'])->name('products.import.view');
    Route::post('products/import/', [ProductImportController::class, 'store'])->name('products.import.store');
    Route::get('products/export/', [ProductExportController::class, 'create'])->name('products.export.store');
    Route::resource('/products', ProductController::class);

   // Route::resource('/detections', DetectionController::class);

    // Route POS
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/cart/add', [PosController::class, 'addCartItem'])->name('pos.addCartItem');
    Route::post('/pos/cart/update/{rowId}', [PosController::class, 'updateCartItem'])->name('pos.updateCartItem');
    Route::delete('/pos/cart/delete/{rowId}', [PosController::class, 'deleteCartItem'])->name('pos.deleteCartItem');

    //Route::post('/pos/invoice', [PosController::class, 'createInvoice'])->name('pos.createInvoice');
    Route::post('invoice/create/', [InvoiceController::class, 'create'])->name('invoice.create');

    // Route Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/pending', OrderPendingController::class)->name('orders.pending');
    Route::get('/orders/complete', OrderCompleteController::class)->name('orders.complete');

    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

    // SHOW ORDER
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');

    // DUES
    Route::get('due/orders/', [DueOrderController::class, 'index'])->name('due.index');
    Route::get('due/order/view/{order}', [DueOrderController::class, 'show'])->name('due.show');
    Route::get('due/order/edit/{order}', [DueOrderController::class, 'edit'])->name('due.edit');
    Route::put('due/order/update/{order}', [DueOrderController::class, 'update'])->name('due.update');

    // TODO: Remove from OrderController
    Route::get('/orders/details/{order_id}/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');


    // Route Purchases
    Route::get('/purchases/approved', [PurchaseController::class, 'approvedPurchases'])->name('purchases.approvedPurchases');
    Route::get('/purchases/report', [PurchaseController::class, 'dailyPurchaseReport'])->name('purchases.dailyPurchaseReport');
    Route::get('/purchases/report/export', [PurchaseController::class, 'getPurchaseReport'])->name('purchases.getPurchaseReport');
    Route::post('/purchases/report/export', [PurchaseController::class, 'exportPurchaseReport'])->name('purchases.exportPurchaseReport');

    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');

    //Route::get('/purchases/show/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

    //Route::get('/purchases/edit/{purchase}', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');

    Route::put('/purchases/update/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/purchases/delete/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.delete');


    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/rapport', [InventoryController::class, 'genererRapport'])->name('inventory.report');
    Route::get('inventory/import/', [InventoryImportController::class, 'create'])->name('inventory.import.view');
    Route::post('inventory/import/', [InventoryExportController::class, 'store'])->name('inventory.import.store');
    Route::get('inventory/export/', [InventoryExportController::class, 'create'])->name('inventory.export.store');
    Route::resource('/inventory', InventoryController::class);

    //Grandlivre
    Route::get('/grand-livre', [GrandLivreController::class, 'index'])->name('grand.index');
    Route::post('/grand-livre', [GrandLivreController::class, 'store'])->name('grand-livre.store');
    Route::get('/grand-livre/soldes-progressifs', [GrandLivreController::class, 'soldesProgressifs'])->name('grand-livre.soldes');
    Route::get('/generate-pdf', [GrandLivreController::class, 'generatePdf'])->name('grand.generate-pdf');


    //contractroutes
    Route::resource('/contracts', ContractsController::class);
    Route::resource('/abc-analysis', ABCAnalysisController::class);


    Route::get('/contracts/{id}/pdf', [ContractsController::class, 'pdf'])->name('contracts.pdf');

});

Route::get('/', function () {
    return view('welcome');
});
require __DIR__.'/auth.php';

Route::get('test', function (){
    return view('test');
});
use App\Http\Controllers\YoloController;

Route::get('/upload', function () {
    return view('yolo.upload');
})->name('upload');

Route::post('/detect', [YoloController::class, 'predict'])->name('detect');






Route::get('/detections/create', [DetectionController::class, 'create'])->name('detections.create');
Route::post('/detections/store', [DetectionController::class, 'store'])->name('detections.store');
Route::get('/detections/result', [DetectionController::class, 'result'])->name('detections.result'); // Assurez-vous que c'est bien "result"




//stock 

// mise a jour 




use App\Http\Controllers\ExportController;

// Accepter la méthode POST pour l'export PDF
Route::post('/export/pdf', [ExportController::class, 'exportPDF'])->name('export.pdf');

// Route pour l'export Excel (peut rester en GET si nécessaire)
Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
