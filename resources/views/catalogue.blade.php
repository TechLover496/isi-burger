@extends('layouts.app')

@section('content')
    <style>
        .hero { padding: 48px 0; display: flex; align-items: center; justify-content: space-between; background: #fff; position: relative; overflow: hidden; margin: -32px -40px 32px; padding: 48px 40px; }
        .hero-glow { position: absolute; right: 160px; top: -80px; width: 420px; height: 420px; background: #F5A58A40; border-radius: 50%; }
        .hero-glow2 { position: absolute; right: 80px; bottom: -100px; width: 300px; height: 300px; background: #F5A58A25; border-radius: 50%; }
        .hero-tag { display: inline-block; background: #FFF0EB; color: #C1440E; font-size: 11px; padding: 6px 16px; border-radius: 20px; margin-bottom: 18px; font-weight: 600; border: 1px solid #f5c9b8; }
        .hero-title { font-size: 44px; font-weight: 800; color: #1a1a1a; line-height: 1.15; margin-bottom: 14px; }
        .hero-title span { color: #C1440E; }
        .hero-sub { font-size: 14px; color: #888; line-height: 1.8; max-width: 380px; margin-bottom: 28px; }
        .hero-stats { display: flex; gap: 28px; margin-bottom: 28px; }
        .stat-val { font-size: 22px; font-weight: 700; color: #1a1a1a; }
        .stat-lbl { font-size: 11px; color: #aaa; margin-top: 2px; }
        .stat-sep { width: 1px; background: #F0EDE8; }
        .hero-btns { display: flex; gap: 12px; }
        .btn-big { background: #C1440E; color: #fff; border: none; padding: 13px 28px; border-radius: 28px; font-size: 14px; cursor: pointer; font-weight: 600; }
        .btn-big-outline { background: transparent; color: #1a1a1a; border: 1.5px solid #E8E4DF; padding: 13px 24px; border-radius: 28px; font-size: 14px; cursor: pointer; }
        .hero-right { flex: 1; display: flex; justify-content: flex-end; position: relative; z-index: 1; }
        .burger-circle { width: 260px; height: 260px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid #F5A58A; position: relative; overflow: visible; padding: 0; }
        .burger-circle img { width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: 50%; }
        .floating-badge { position: absolute; background: #fff; border: 1px solid #F0EDE8; border-radius: 12px; padding: 10px 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.06); z-index: 2; }
        .fb1 { top: 10px; right: -60px; }
        .fb2 { bottom: 20px; left: -60px; background: #C1440E; border-color: #C1440E; }
        .fb-title { font-size: 12px; font-weight: 700; color: #1a1a1a; }
        .fb-sub { font-size: 10px; color: #aaa; margin-top: 1px; }
        .fb2 .fb-title { color: #fff; }
        .fb2 .fb-sub { color: #ffcbb8; }
        .features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 32px; }
        .feature { background: #fff; border-radius: 14px; padding: 18px 20px; border: 1px solid #F0EDE8; display: flex; align-items: center; gap: 14px; }
        .feature-icon { font-size: 26px; }
        .feature-title { font-size: 13px; font-weight: 600; color: #1a1a1a; margin-bottom: 2px; }
        .feature-sub { font-size: 11px; color: #aaa; }
        .section-title { font-size: 20px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
        .section-sub { font-size: 13px; color: #aaa; margin-bottom: 20px; }
        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 32px; }
        .card { background: #fff; border-radius: 16px; border: 2px solid #F0EDE8; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s; cursor: pointer; }
        .card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(193,68,14,0.08); border-color: #f5c9b8; }
        .card.selected { border-color: #C1440E; box-shadow: 0 8px 24px rgba(193,68,14,0.15); }
        .card-img { background: #fff; text-align: center; font-size: 60px; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
        .card-img img { width: 100%; height: 200px; object-fit: contain; background: #fff; }
        .card-selected-badge { position: absolute; top: 10px; right: 10px; background: #C1440E; color: #fff; width: 28px; height: 28px; border-radius: 50%; display: none; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; }
        .card.selected .card-selected-badge { display: flex; }
        .card-body { padding: 16px; }
        .card-name { font-size: 15px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
        .card-desc { font-size: 13px; color: #aaa; margin-bottom: 14px; line-height: 1.6; }
        .card-footer { display: flex; align-items: center; justify-content: space-between; }
        .card-price { font-size: 16px; font-weight: 700; color: #C1440E; }
        .qty-controls { display: none; align-items: center; gap: 8px; }
        .card.selected .qty-controls { display: flex; }
        .qty-btn { background: #F0EDE8; border: none; width: 28px; height: 28px; border-radius: 50%; font-size: 16px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        .qty-btn:hover { background: #C1440E; color: #fff; }
        .qty-num { font-size: 15px; font-weight: 700; min-width: 20px; text-align: center; }
        .cart-bar { position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); background: #1a1a1a; color: #fff; padding: 16px 32px; border-radius: 32px; display: none; align-items: center; gap: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.2); z-index: 999; }
        .cart-bar.show { display: flex; }
        .cart-info { font-size: 14px; }
        .cart-total { font-size: 16px; font-weight: 700; color: #F5A58A; }
        .btn-passer { background: #C1440E; color: #fff; border: none; padding: 10px 24px; border-radius: 20px; font-size: 14px; cursor: pointer; font-weight: 600; }
        .empty { text-align: center; padding: 60px; color: #aaa; font-size: 16px; }
    </style>

    <div class="hero">
        <div class="hero-glow"></div>
        <div class="hero-glow2"></div>
        <div style="flex:1;position:relative;z-index:1;">
            <div class="hero-tag">Nouveau menu disponible</div>
            <div class="hero-title">Le burger qui fait<br><span>craquer Dakar</span></div>
            <div class="hero-sub">Ingrédients frais, recettes maison, livraison rapide. L'expérience burger ultime à Dakar.</div>
            <div class="hero-stats">
                <div><div class="stat-val">500+</div><div class="stat-lbl">Clients satisfaits</div></div>
                <div class="stat-sep"></div>
                <div><div class="stat-val">12</div><div class="stat-lbl">Burgers au menu</div></div>
                <div class="stat-sep"></div>
                <div><div class="stat-val">4.9</div><div class="stat-lbl">Note moyenne</div></div>
            </div>
            <div class="hero-btns">
                @guest
                    <a href="{{ route('register') }}"><button class="btn-big">Commander maintenant</button></a>
                    <a href="{{ route('login') }}"><button class="btn-big-outline">Se connecter</button></a>
                @endguest
                @auth
                    <a href="#menu"><button class="btn-big">Voir le menu</button></a>
                @endauth
            </div>
        </div>
        <div class="hero-right">
            <div class="burger-circle">
                <img src="{{ asset('images/burger.jpg') }}" alt="Burger ISI">
                <div class="floating-badge fb1">
                    <div class="fb-title">Livraison rapide</div>
                    <div class="fb-sub">En 30 minutes</div>
                </div>
                <div class="floating-badge fb2">
                    <div class="fb-title">Frais du jour</div>
                    <div class="fb-sub">Qualité garantie</div>
                </div>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="feature">
            <div class="feature-icon">🚀</div>
            <div><div class="feature-title">Livraison rapide</div><div class="feature-sub">Commande livrée en 30 min</div></div>
        </div>
        <div class="feature">
            <div class="feature-icon">🥩</div>
            <div><div class="feature-title">Ingrédients frais</div><div class="feature-sub">Qualité garantie chaque jour</div></div>
        </div>
        <div class="feature">
            <div class="feature-icon">💳</div>
            <div><div class="feature-title">Paiement facile</div><div class="feature-sub">Espèces à la livraison</div></div>
        </div>
    </div>

    <div id="menu">
        <div class="section-title">Nos Burgers</div>
        <div class="section-sub">Fraîchement préparés pour vous</div>
    </div>

    @if($produits->isEmpty())
        <div class="empty">Aucun produit disponible pour le moment.</div>
    @else
        @guest
            <div class="cards">
                @foreach($produits as $produit)
                    <div class="card">
                        <div class="card-img">
                            @if($produit->image)
                                <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}">
                            @else
                                🍔
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="card-name">{{ $produit->nom }}</div>
                            <div class="card-desc">{{ $produit->description }}</div>
                            <div class="card-footer">
                                <span class="card-price">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                <a href="{{ route('login') }}" style="background:#C1440E;color:#fff;padding:6px 14px;border-radius:20px;font-size:12px;text-decoration:none;font-weight:600;">Connectez-vous</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endguest

        @auth
            @if(auth()->user()->role === 'client')
                <form method="POST" action="{{ route('commandes.store') }}" id="commandeForm">
                    @csrf
                    <div class="cards">
                        @foreach($produits as $produit)
                            <div class="card" onclick="toggleCard(this, {{ $produit->id }}, {{ $produit->prix }})">
                                <div class="card-img">
                                    @if($produit->image)
                                        <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}">
                                    @else
                                        🍔
                                    @endif
                                    <div class="card-selected-badge">✓</div>
                                </div>
                                <div class="card-body">
                                    <div class="card-name">{{ $produit->nom }}</div>
                                    <div class="card-desc">{{ $produit->description }}</div>
                                    <div class="card-footer">
                                        <span class="card-price">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                        <div class="qty-controls" onclick="event.stopPropagation()">
                                            <button type="button" class="qty-btn" onclick="changeQty(this, -1, {{ $produit->id }}, {{ $produit->prix }})">-</button>
                                            <span class="qty-num">1</span>
                                            <button type="button" class="qty-btn" onclick="changeQty(this, 1, {{ $produit->id }}, {{ $produit->prix }})">+</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="produits[{{ $produit->id }}]" value="0" id="qty_{{ $produit->id }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="cart-bar" id="cartBar">
                        <div class="cart-info"><span id="cartCount">0</span> burger(s) sélectionné(s)</div>
                        <div class="cart-total" id="cartTotal">0 FCFA</div>
                        <button type="submit" class="btn-passer">Commander maintenant</button>
                    </div>
                </form>
            @else
                <div class="cards">
                    @foreach($produits as $produit)
                        <div class="card">
                            <div class="card-img">
                                @if($produit->image)
                                    <img src="{{ asset('storage/'.$produit->image) }}" alt="{{ $produit->nom }}">
                                @else
                                    🍔
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="card-name">{{ $produit->nom }}</div>
                                <div class="card-desc">{{ $produit->description }}</div>
                                <div class="card-footer">
                                    <span class="card-price">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endauth
    @endif

    <script>
        let cartTotal = 0;
        let cartCount = 0;

        function toggleCard(card, produitId, prix) {
            card.classList.toggle('selected');
            const qtyInput = document.getElementById('qty_' + produitId);
            const qtyNum = card.querySelector('.qty-num');
            if (card.classList.contains('selected')) {
                qtyInput.value = 1;
                qtyNum.textContent = 1;
                cartTotal += prix;
                cartCount++;
            } else {
                const qty = parseInt(qtyNum.textContent);
                cartTotal -= prix * qty;
                cartCount -= qty;
                qtyInput.value = 0;
                qtyNum.textContent = 1;
            }
            updateCart();
        }

        function changeQty(btn, delta, produitId, prix) {
            const card = btn.closest('.card');
            const qtyNum = card.querySelector('.qty-num');
            const qtyInput = document.getElementById('qty_' + produitId);
            let qty = parseInt(qtyNum.textContent);
            qty = Math.max(1, qty + delta);
            const oldQty = parseInt(qtyInput.value);
            qtyInput.value = qty;
            qtyNum.textContent = qty;
            cartTotal += prix * (qty - oldQty);
            cartCount += (qty - oldQty);
            updateCart();
        }

        function updateCart() {
            const cartBar = document.getElementById('cartBar');
            document.getElementById('cartCount').textContent = cartCount;
            document.getElementById('cartTotal').textContent = new Intl.NumberFormat('fr-FR').format(cartTotal) + ' FCFA';
            cartBar.classList.toggle('show', cartCount > 0);
        }
    </script>
@endsection
