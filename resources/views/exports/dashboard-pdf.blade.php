<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport d'Inventaire</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        tr.alert { background-color: #ffcccc; } 

        /* ✅ Encadrement des Graphiques */
        .chart-container {
            border: 2px solid #333;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        /* ✅ Style des Titres */
        .chart-title {
            background-color: #e0e0e0;
            padding: 8px;
            font-weight: bold;
            border: 1px solid #000;
            text-align: center;
            margin-bottom: 5px;
        }

        img { width: 100%; max-height: 300px; }

        /* ✅ Éviter la séparation des titres et tables/graphes */
        .section {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        footer { text-align: center; font-size: 12px; color: gray; margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Rapport d'Inventaire</h1>

    <!-- ✅ Statistiques Générales -->
    <h2>Résumé des Statistiques</h2>
    <table>
        <tr>
            <th>Total Produits</th>
            <th>Produits en Alerte</th>
            <th>Catégories Impactées</th>
        </tr>
        <tr>
            <td>{{ $totalProducts }}</td>
            <td style="color: red;">{{ $totalLowStock }}</td>
            <td>{{ $totalCriticalCategories }}</td>
        </tr>
    </table>

    <!-- 📈 Graphiques Encadrés -->
    @foreach ($charts as $title => $chart)
        <div class="section">
            <div class="chart-title">
                @if(!isset($isPdf)) 
                    {{ $title }} 
                @else 
                    {{ preg_replace('/[^\p{L}\p{N}\s]/u', '', $title) }} 
                @endif
            </div> 
            <div class="chart-container">
                <img src="{{ $chart }}" alt="Graphique">
            </div>
        </div>
    @endforeach


    <!-- 📋 Liste des Produits (Titre et Table Ensemble) -->
    <div class="section">
        <h2>Liste des Produits</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom du Produit</th>
                    <th>Quantité</th>
                    <th>Seuil d'Alerte</th>
                    <th>Catégorie</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="{{ $product->quantity < $product->quantity_alert ? 'alert' : '' }}">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->quantity_alert }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer>
        Rapport généré automatiquement - {{ now()->format('d/m/Y H:i') }}
    </footer>

</body>
</html>
