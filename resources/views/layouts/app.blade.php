<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISI BURGER</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background: #FAFAF8; color: #1a1a1a; }
        .nav { background: #fff; padding: 16px 40px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #F0EDE8; position: sticky; top: 0; z-index: 100; }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-box { width: 38px; height: 38px; background: #C1440E; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
        .logo-text { font-size: 17px; font-weight: 700; color: #1a1a1a; }
        .logo-text span { color: #C1440E; }
        .nav-links { display: flex; gap: 28px; align-items: center; }
        .nav-links a { font-size: 14px; color: #888; text-decoration: none; transition: color 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: #C1440E; font-weight: 600; }
        .btn { padding: 9px 22px; border-radius: 24px; font-size: 13px; cursor: pointer; border: none; font-weight: 600; transition: all 0.2s; }
        .btn-primary { background: #C1440E; color: #fff; }
        .btn-primary:hover { background: #a83509; }
        .btn-outline { background: transparent; border: 1.5px solid #E8E4DF; color: #1a1a1a; }
        .btn-outline:hover { border-color: #C1440E; color: #C1440E; }
        .container { max-width: 1200px; margin: 0 auto; padding: 32px 40px; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca; }
    </style>
</head>
<body>
<nav class="nav">
    <a href="{{ route('catalogue') }}" class="logo">
        <div class="logo-box">🍔</div>
        <div class="logo-text">ISI <span>BURGER</span></div>
    </a>
    <div class="nav-links">
        <a href="{{ route('catalogue') }}" class="{{ request()->routeIs('catalogue') ? 'active' : '' }}">Catalogue</a>
        @auth
            <a href="{{ route('commandes.index') }}" class="{{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                @if(auth()->user()->role === 'gestionnaire') Toutes les commandes @else Mes commandes @endif
            </a>
            @if(auth()->user()->role === 'gestionnaire')
                <a href="{{ route('produits.index') }}" class="{{ request()->routeIs('produits.*') ? 'active' : '' }}">Produits</a>
                <a href="{{ route('statistiques.index') }}" class="{{ request()->routeIs('statistiques.*') ? 'active' : '' }}">Statistiques</a>
            @endif
        @endauth
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        @auth
            <span style="font-size:13px;color:#888;">Bonjour, <strong>{{ auth()->user()->name }}</strong></span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-outline">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}"><button class="btn btn-outline">Connexion</button></a>
            <a href="{{ route('register') }}"><button class="btn btn-primary">S'inscrire</button></a>
        @endauth
    </div>
</nav>
<div class="container">
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif
    @yield('content')
</div>
</body>
</html>
