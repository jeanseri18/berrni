<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BERRNI — La confiance voyage</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="nav-wrap">
       
            <nav class="main-nav">
                <a href="/" class="nav-link active">Accueil</a>
                <a href="/comment" class="nav-link">Comment ça marche</a>
                <a href="/" class="nav-logo" aria-label="BERRNI">
                    <img src="{{ asset('Logo_BERRNI-removebg-preview.png') }}" alt="BERRNI" class="brand-logo brand-logo-inline">
                </a>
                <a href="/apropos" class="nav-link">À propos</a>
                <a href="/faq" class="nav-link">FAQ</a>
                <a href="/contact" class="nav-link">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-inner">
            <span>©{{ date('Y') }} BERRNI</span>

            <a href="/cgu" class="footer-link">Conditions Générale d’Utilisation</a>
            <span class="sep">·</span>
            <a href="/charte" class="footer-link">Charte du Relais</a>
            <span class="sep">·</span>
            <a href="/charte-expediteur" class="footer-link">Charte de l’Expéditeur</a>
            <span class="sep">·</span>
            <span>Tous droits réservés.</span>
        </div>
    </footer>
</body>
</html>