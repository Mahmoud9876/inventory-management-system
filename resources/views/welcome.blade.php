<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Intelligente des Stocks</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: url('{{ asset('computer-vision.webp') }}') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            overflow-y: auto;
        }
        .overlay {
            background: rgba(0, 0, 0, 0.6);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .content {
            position: relative;
            z-index: 2;
            max-width: 700px;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
        h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        p {
            font-size: 1.3rem;
            margin-bottom: 25px;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            padding: 14px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            border-radius: 5px;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }
        .btn:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        section {
            margin: 60px 0;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            z-index: 2;
            max-width: 900px;
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in-out;
        }
        h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .services ul {
            list-style: none;
            padding: 0;
        }
        .services li {
            font-size: 1.2rem;
            margin-bottom: 12px;
        }
        .about p {
            font-size: 1.2rem;
            line-height: 1.6;
        }

        /* Animation de fondu */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="overlay"></div>
<div class="content">
    <h1>Gestion Intelligente des Stocks</h1>
    <p>Optimisez votre gestion de stock avec notre technologie avancée de vision par ordinateur.</p>
    <a href="{{ route('login') }}" class="btn">Se Connecter</a>
</div>

<!-- Section Nos Services -->
<section id="services" class="services">
    <h2>Nos Services</h2>
    <ul>
        <li>📦 Détection automatique des stocks en temps réel.</li>
        <li>📊 Analyse intelligente des niveaux de stock.</li>
        <li>🔍 Suivi des produits via vision par ordinateur.</li>
        <li>🚀 Optimisation des flux de stock pour améliorer la productivité.</li>
    </ul>
</section>

<!-- Section À Propos -->
<section id="about" class="about">
    <h2>À Propos</h2>
    <p>Nous sommes une équipe passionnée par la technologie, dédiée à l’optimisation de la gestion des stocks grâce à l’intelligence artificielle et la vision par ordinateur.</p>
</section>

</body>
</html>
