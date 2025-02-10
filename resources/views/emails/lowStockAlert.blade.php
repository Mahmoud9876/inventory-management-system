<!DOCTYPE html>
<html>
<head>
    <title>Alerte Stock Faible</title>
</head>
<body>
    <h2>⚠️ Alerte Stock Faible</h2>
    <p>Bonjour,</p>
    <p>Le produit <strong>{{ $product->name }}</strong> a atteint un niveau critique.</p>
    <ul>
        <li><strong>Stock actuel :</strong> {{ $product->quantity }}</li>
        <li><strong>Seuil d’alerte :</strong> {{ $product->quantity_alert }}</li>
    </ul>
    <p>Veuillez approvisionner ce produit dès que possible.</p>
    <p>Merci,</p>
    <p><strong>Votre Système de Gestion de Stock</strong></p>
</body>
</html>
