<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class YoloController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // Max 10MB
        ]);

        // Enregistrer l’image localement
        $file = $request->file('image');
        $filePath = $file->store('uploads', 'public');
        $storagePath = storage_path("app/public/{$filePath}");

        if (!file_exists($storagePath)) {
            Log::error("Fichier non trouvé : {$storagePath}");
            return response()->json(["error" => "L'image n'a pas été trouvée après l'upload."], 400);
        }

        // Envoyer l’image à Flask
        $flask_url = 'http://127.0.0.1:5000/predict';
        try {
            $response = Http::attach(
                'file', file_get_contents($storagePath), $file->getClientOriginalName()
            )->timeout(60)->post($flask_url);

            if ($response->successful()) {
                $data = $response->json();
                return view('yolo.result', [
                    'original_image' => asset("storage/{$filePath}"),
                    'processed_image' => $data['processed_image'],
                    'inventory' => $data['inventory']
                ]);
            } else {
                Log::error("Erreur Flask : " . $response->body());
                return response()->json(["error" => "Erreur lors du traitement Flask"], 500);
            }
        } catch (\Exception $e) {
            Log::error("Erreur connexion Flask : " . $e->getMessage());
            return response()->json(["error" => "Impossible de contacter le serveur Flask"], 500);
        }
    }
}
