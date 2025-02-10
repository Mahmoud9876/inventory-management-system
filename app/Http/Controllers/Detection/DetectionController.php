<?php

namespace App\Http\Controllers\Detection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class DetectionController extends Controller
{
    /**
     * Afficher le formulaire de détection
     */
    public function create()
    {
        return view('detections.create');
    }

    /**
     * Traiter l'image envoyée et envoyer la requête à Flask
     */
    public function store(Request $request)
{
        $request->validate([
            'product_image' => 'required|image|max:5120',
        ]);

        $file = $request->file('product_image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');
        $storagePath = storage_path("app/public/{$filePath}");

        if (!Storage::disk('public')->exists("uploads/{$fileName}")) {
            return back()->with('error', "L'image n'a pas été trouvée.");
        }

        $flask_url = 'http://127.0.0.1:5000/predict';

        try {
            $response = Http::attach(
                'file', file_get_contents($storagePath), $fileName
            )->timeout(60)->post($flask_url);

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['inventory'] as $key => $value) {
                    $product = Product::where('name', $key)->first();
                    if ($product) {
                        $product->update(['quantity' => $value]);

                        // ✅ Compter les détections dans la session
                        $detections = session('detections', []);
                        $detections[$key] = ($detections[$key] ?? 0) + 1;
                        session(['detections' => $detections]);
                    }
                }

                session(['inventory' => $data['inventory'] ?? []]);
                session()->save();

                return redirect()->route('detections.result')->with([
                    'original_image' => asset("storage/{$filePath}"),
                    'processed_image' => $data['processed_image'] ?? null,
                    'inventory' => $data['inventory'] ?? []
                ]);
            } else {
                return back()->with('error', "Erreur lors du traitement YOLO.");
            }
        } catch (\Exception $e) {
            return back()->with('error', "Impossible de contacter le serveur Flask.");
        }
}



 

    /**
     * Afficher les résultats de la détection
     */
   public function result()
{  
    return view('detections.result')->with([
        'original_image' => session('original_image'),
        'processed_image' => session('processed_image'),
        'inventory' => session('inventory')
    ]);
}
    
}

