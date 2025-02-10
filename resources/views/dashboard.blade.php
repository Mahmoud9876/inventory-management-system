@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <!-- 📊 Statistiques Générales -->
    <div class="row row-deck">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center p-4">
                <h3>Total Produits</h3>
                <h1>{{ $totalProducts }}</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white text-center p-4">
                <h3>Produits en Alerte</h3>
                <h1>{{ $totalLowStock }}</h1>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white text-center p-4">
                <h3>Catégories Impactées</h3>
                <h1>{{ $totalCriticalCategories }}</h1>
            </div>
        </div>
    </div>

    <!-- 📈 Graphiques des Statistiques -->
    <div class="row my-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Tendances des Stocks 📈</div>
                <div class="card-body">
                    <canvas id="stockTrendsChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Répartition des Produits 🗂️</div>
                <div class="card-body">
                    <canvas id="categoryDistributionChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Produits Proches du Seuil d'Alerte 🚨</div>
                <div class="card-body">
                    <canvas id="nearAlertChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">État du Stock ✅🚩</div>
                <div class="card-body">
                    <canvas id="stockStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- 🎯 Graphique des Produits Détectés -->
    <div class="card my-4">
        <div class="card-header text-center">Fréquence des Produits Détectés 📊</div>
        <div class="card-body">
            <canvas id="detectedProductsChart" height="200"></canvas>
        </div>
    </div>


    <!-- 📤 Exportation des Rapports -->
    <div class="text-end my-3">
        <button onclick="exportPDF()" class="btn btn-danger">📄 Exporter en PDF</button>
        <a href="{{ route('export.excel') }}" class="btn btn-success">📊 Exporter en Excel</a>
    </div>
    <!-- 🔎 Filtres pour la Table des Produits -->
    <div class="card my-4">
        <div class="card-header text-center">🔎 Filtres des Produits</div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard') }}" class="row g-3">
                <!-- 📂 Filtre par Catégorie -->
                <div class="col-md-4">
                    <label for="category" class="form-label">Catégorie</label>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes les Catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 📊 Filtre par État de Stock -->
                <div class="col-md-4">
                    <label for="stock_status" class="form-label">État du Stock</label>
                    <select name="stock_status" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ request('stock_status') == 'all' ? 'selected' : '' }}>Tous</option>
                        <option value="alert" {{ request('stock_status') == 'alert' ? 'selected' : '' }}>En Alerte</option>
                        <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Disponible</option>
                    </select>
                </div>

                <!-- 📅 Filtre par Date de Mise à Jour -->
                <div class="col-md-4">
                    <label for="date" class="form-label">Date de Mise à Jour</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    <!-- 📋 Liste des Produits avec Filtres -->
    <div class="card my-4">
        <div class="card-header text-center">Liste des Produits 🗂️</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Stock</th>
                        <th>Seuil d'Alerte</th>
                        <th>Catégorie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td class="{{ $product->quantity < $product->quantity_alert ? 'text-danger' : '' }}">
                                {{ $product->quantity }}
                            </td>
                            <td>{{ $product->quantity_alert }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 📊 Scripts Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 📈 Tendances des Stocks
    new Chart(document.getElementById('stockTrendsChart'), {
        type: 'line',
        data: {
            labels: @json($stockTrends->pluck('name')),
            datasets: [{
                label: 'Quantité en Stock',
                data: @json($stockTrends->pluck('quantity')),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.2)',
                borderWidth: 2
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 📊 Répartition des Produits par Catégorie
    new Chart(document.getElementById('categoryDistributionChart'), {
        type: 'pie',
        data: {
            labels: @json($productDistribution->pluck('category.name')),
            datasets: [{
                data: @json($productDistribution->pluck('total')),
                backgroundColor: ['#0d6efd', '#dc3545', '#ffc107', '#28a745', '#6f42c1'],
                borderWidth: 1
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 🚨 Produits Proches du Seuil d'Alerte
    new Chart(document.getElementById('nearAlertChart'), {
        type: 'bar',
        data: {
            labels: @json($nearAlertProducts->pluck('name')),
            datasets: [{
                label: 'Proche du Seuil d\'Alerte',
                data: @json($nearAlertProducts->pluck('quantity')),
                backgroundColor: '#ffc107',
                borderWidth: 1
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // ✅ Stock Disponible vs En Alerte
    new Chart(document.getElementById('stockStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Disponible', 'En Alerte'],
            datasets: [{
                data: [{{ $stockStatusChart['available'] }}, {{ $stockStatusChart['alert'] }}],
                backgroundColor: ['#28a745', '#dc3545']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    
    // 🎯 Fréquence des Produits Détectés
    new Chart(document.getElementById('detectedProductsChart'), {
        type: 'bar',
        data: {
            labels: @json(array_keys($detections)),  // ✅ Produits détectés
            datasets: [{
                label: 'Nombre de Détections',
                data: @json(array_values($detections)), // ✅ Nombre de détections
                backgroundColor: '#6610f2',
                borderColor: '#6f42c1',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Fréquence des Produits Détectés 🚀',
                    font: {
                        size: 18
                    }
                }
            }
        }
    });



    // 📤 Exportation PDF
    function exportPDF() {
        const charts = [
            document.getElementById('stockTrendsChart')?.toDataURL(),
            document.getElementById('categoryDistributionChart')?.toDataURL(),
            document.getElementById('nearAlertChart')?.toDataURL(),
            document.getElementById('stockStatusChart')?.toDataURL(),
            document.getElementById('detectedProductsChart')?.toDataURL()  // ✅ Export du graphique des détections
        ].filter(Boolean);

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("export.pdf") }}';

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        form.appendChild(token);

        const chartsInput = document.createElement('input');
        chartsInput.type = 'hidden';
        chartsInput.name = 'charts';
        chartsInput.value = JSON.stringify(charts);
        form.appendChild(chartsInput);

        document.body.appendChild(form);
        form.submit();
    }


</script>
@endsection
