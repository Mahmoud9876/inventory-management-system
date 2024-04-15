<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use Illuminate\View\View;
use Dompdf\Dompdf;
use Dompdf\Options;

class GrandLivreController extends Controller
{
    /**
     * Affiche la page d'accueil du grand livre avec les entrées existantes.
     */
    public function index(): View
    {
        // Récupérez les entrées triées par date
        $entries = Entry::orderBy('date')->get();

        // Calculez les soldes progressifs pour chaque entrée
        $soldeProgressif = 0;
        foreach ($entries as $entry) {
            $entry->solde_progressif = $soldeProgressif += $entry->montant;
        }

        return view('GrandLivre.index', compact('entries'));
    }

    /**
     * Enregistre une nouvelle entrée dans le grand livre.
     */
    public function store(Request $request)
    {
        // Validez les données du formulaire si nécessaire
        $validatedData = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'compte_debit' => 'required|string',
            'compte_credit' => 'required|string',
            'montant' => 'required|numeric',
        ]);

        // Récupérez les données du formulaire
        $data = $request->only(['date', 'description', 'compte_debit', 'compte_credit', 'montant']);

        // Insérez une nouvelle entrée dans la table 'entries'
        Entry::create($data);

        // Redirigez vers la page du grand livre avec un message de succès
        return redirect()->route('grand.index')->with('success', 'Entrée ajoutée avec succès.');
    }

    /**
     * Calcule et affiche les soldes progressifs.
     */
    public function soldesProgressifs()
    {
        // Calculez les soldes progressifs pour chaque entrée
        $entries = Entry::orderBy('date')->get();
        $soldeProgressif = 0;
        foreach ($entries as $entry) {
            $soldeProgressif += $entry->montant;
            $entry->solde_progressif = $soldeProgressif;
        }

        // Affichez les soldes dans une vue dédiée
        return view('GrandLivre.soldes-progressifs', compact('entries'));
    }

    // Vous pouvez ajouter d'autres méthodes selon vos besoins
    public function generatePdf()
{
    // Récupérer les données pour le PDF
    $entries = Entry::orderBy('date')->get();
    $runningBalance = 0;

    // Créer une nouvelle instance Dompdf
    $dompdf = new Dompdf();

    // Charger la vue PDF avec les données
    $html = view('GrandLivre.pdf', compact('entries', 'runningBalance'))->render();

    // Options pour le PDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    // Appliquer les options à Dompdf
    $dompdf->setOptions($options);

    // Charger le contenu HTML dans Dompdf
    $dompdf->loadHtml($html);

    // Rendre le PDF
    $dompdf->render();

    // Télécharger le PDF
    return $dompdf->stream("entries.pdf");
}
}
