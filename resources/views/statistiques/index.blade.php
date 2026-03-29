@extends('layouts.app')
@section('content')
    <style>
        .page-title { font-size: 26px; font-weight: 800; margin-bottom: 6px; }
        .page-sub { font-size: 14px; color: #aaa; margin-bottom: 28px; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
        .stat { background: #fff; border-radius: 16px; padding: 22px 24px; border: 1px solid #F0EDE8; }
        .stat-icon { font-size: 28px; margin-bottom: 12px; }
        .stat-val { font-size: 28px; font-weight: 800; color: #C1440E; margin-bottom: 4px; }
        .stat-lbl { font-size: 13px; color: #aaa; }
        .charts { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .chart-card { background: #fff; border-radius: 16px; padding: 28px; border: 1px solid #F0EDE8; }
        .chart-title { font-size: 16px; font-weight: 700; margin-bottom: 20px; color: #1a1a1a; }
    </style>

    <div class="page-title">Statistiques</div>
    <div class="page-sub">Vue d'ensemble des performances du restaurant</div>

    <div class="stats">
        <div class="stat">
            <div class="stat-icon">📦</div>
            <div class="stat-val">{{ $commandesJour }}</div>
            <div class="stat-lbl">Commandes aujourd'hui</div>
        </div>
        <div class="stat">
            <div class="stat-icon">✅</div>
            <div class="stat-val">{{ $commandesValidees }}</div>
            <div class="stat-lbl">Validées aujourd'hui</div>
        </div>
        <div class="stat">
            <div class="stat-icon">💰</div>
            <div class="stat-val">{{ number_format($recetteJour, 0, ',', ' ') }} F</div>
            <div class="stat-lbl">Recette du jour</div>
        </div>
        <div class="stat">
            <div class="stat-icon">🍔</div>
            <div class="stat-val">{{ $totalProduits }}</div>
            <div class="stat-lbl">Produits actifs</div>
        </div>
    </div>

    <div class="charts">
        <div class="chart-card">
            <div class="chart-title">Commandes par mois</div>
            <canvas id="chartCommandes" height="200"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-title">Produits par catégorie</div>
            <canvas id="chartProduits" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('chartCommandes'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($mois) !!},
                datasets: [
                    {
                        label: 'Total commandes',
                        data: {!! json_encode($commandesParMois) !!},
                        backgroundColor: '#F5A58A',
                        borderRadius: 8,
                    },
                    {
                        label: 'Commandes payées',
                        data: {!! json_encode($commandesPayeesParMois) !!},
                        backgroundColor: '#C1440E',
                        borderRadius: 8,
                    }
                ]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { padding: 20, font: { size: 13 } }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#F0EDE8' } },
                    x: { grid: { display: false } }
                }
            }
        });

        new Chart(document.getElementById('chartProduits'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoriesLabels) !!},
                datasets: [{
                    data: {!! json_encode($categoriesData) !!},
                    backgroundColor: ['#C1440E', '#F5A58A'],
                    borderWidth: 0,
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 20, font: { size: 13 } } }
                },
                cutout: '65%'
            }
        });
    </script>
@endsection
