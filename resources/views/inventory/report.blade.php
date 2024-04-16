<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <style>
        /* Ajoutez votre CSS personnalisé pour le style du PDF ici */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Inventory Report</h1>
    
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Stock Physical</th>
                <th>Total Price</th>
                <!-- Ajoutez d'autres en-têtes de colonnes au besoin -->
            </tr>
        </thead>
        <tbody>
            @foreach($inventoryItems as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->selling_price }}</td>
                    <td>{{ $item->stock_phy }}</td>
                    <td>{{ $item->quantity * $item->selling_price }}</td>
                    <!-- Ajoutez d'autres colonnes au besoin -->
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Quantity: {{ $totalQuantity }}</p>
    <p>Total Price: {{ $totalPrice }}</p>
</body>
</html>


