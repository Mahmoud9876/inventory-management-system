<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOLO - Détection d'Objets</title>
</head>
<body>

    <h2>YOLO - Détection d'Objets</h2>
    <form action="{{ route('detect') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Analyser</button>
    </form>

</body>
</html>
