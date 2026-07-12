@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #007bff;
        --success: #28a745;
        --dark: #343a40;
        --gray: #6c757d;
        --bg: #f4f6f9;
        --shadow: 0 4px 6px rgba(0,0,0,0.07);
    }

    .dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* TITRES */
    .header-box { margin-bottom: 30px; }
    .header-box h1 { font-size: 2rem; color: var(--dark); margin-bottom: 5px; }
    .header-box h2 { font-size: 1.1rem; color: var(--gray); font-weight: 400; }

    /* GRILLES */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    /* COMPOSANTS CARD */
    .custom-card {
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: var(--shadow);
        border: none;
    }

    .stat-card {
        border-top: 4px solid var(--primary);
        transition: transform 0.2s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-card h3 { font-size: 0.85rem; color: var(--gray); text-transform: uppercase; margin: 0; }
    .stat-card .value { font-size: 1.8rem; font-weight: 700; color: var(--dark); margin-top: 10px; }

    /* SECTION ADMIN */
    .admin-alert {
        background: #e9ecef;
        border-left: 5px solid var(--dark);
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* CONTACTS */
    .contact-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }
    .contact-item:last-child { border-bottom: none; }
    .avatar-circle {
        border-radius: 50%;
        object-fit: cover;
        background: #eee;
    }

    .btn-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .btn-link:hover { text-decoration: underline; }

    @media(max-width: 768px) {
        .main-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-wrapper">

    <!-- EN-TÊTE -->
    <div class="header-box">
        <h1>📊 Dashboard CRM</h1>
        <h2>Bienvenue, <strong>{{ $user->name }}</strong> 👋 <small>({{ $user->email }})</small></h2>
    </div>

    <!-- ZONE ADMIN (Uniquement pour Super Admin) -->
    @role('Super Admin')
        <div class="admin-alert">
            <div>
                <strong>⚙️ Administration :</strong> Vous avez accès aux fonctions avancées.
                <span class="ms-3">Admin enregistrés : <code>{{ $totalAdmins }}</code> | Super Admins : <code>{{ $totalSuperAdmins }}</code></span>
            </div>
            <div>
                <a href="/users" class="btn-link me-3">👥 Gérer Utilisateurs</a>
                <a href="/activities" class="btn-link">📋 Historique</a>
            </div>
        </div>
    @endrole

    <!-- STATISTIQUES PRINCIPALES -->
    <div class="cards-grid">
        <div class="custom-card stat-card">
            <h3>Total contacts</h3>
            <div class="value">{{ $totalContacts }}</div>
        </div>
        <div class="custom-card stat-card" style="border-top-color: var(--success);">
            <h3>Emails</h3>
            <div class="value">{{ $emailsCount }}</div>
        </div>
        <div class="custom-card stat-card" style="border-top-color: #ffc107;">
            <h3>Téléphones</h3>
            <div class="value">{{ $phonesCount }}</div>
        </div>
    </div>

    <div class="main-grid">
        <!-- COLONNE GAUCHE : DERNIER CONTACT -->
        <div class="custom-card">
            <h3 class="mb-4">🆕 Dernier contact</h3>
            @if($latestContact)
                <div class="d-flex align-items-center gap-4 p-3 bg-light rounded shadow-sm">
                    @if($latestContact->photo)
                        <img class="avatar-circle" src="{{ asset('storage/'.$latestContact->photo) }}" width="80" height="80">
                    @else
                        <img class="avatar-circle" src="https://ui-avatars.com/api/?name={{ urlencode($latestContact->name) }}&background=random" width="80" height="80">
                    @endif
                    <div>
                        <h4 class="m-0">{{ $latestContact->name }}</h4>
                        <p class="text-muted m-0">📧 {{ $latestContact->email }}</p>
                        <p class="text-muted m-0">📞 {{ $latestContact->phone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            @else
                <p class="text-muted">Aucun contact enregistré pour le moment.</p>
            @endif

            <div class="mt-5">
                <h3 class="mb-4">📈 Croissance</h3>
                <canvas id="contactsChart" height="150"></canvas>
            </div>
        </div>

        <!-- COLONNE DROITE : RÉCENTS -->
        <div class="custom-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="m-0">🕒 Récents</h3>
                @role('Super Admin')
                    <a href="/contacts" class="btn-link">Voir tout →</a>
                @endrole
            </div>

            @forelse($recentContacts as $contact)
                <div class="contact-item">
                    @php $photo = $contact->photo ? asset('storage/'.$contact->photo) : 'https://ui-avatars.com/api/?name='.urlencode($contact->name); @endphp
                    <img src="{{ $photo }}" class="avatar-circle" width="40" height="40">
                    <div style="min-width: 0;">
                        <div class="text-truncate font-weight-bold" style="font-size: 0.9rem;">{{ $contact->name }}</div>
                        <small class="text-muted text-truncate d-block">{{ $contact->email }}</small>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center py-4">Aucun contact récent.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('contactsChart').getContext('2d');
        
        const labels = {!! json_encode(collect($contactsPerMonth)->pluck('month')) !!};
        const totals = {!! json_encode(collect($contactsPerMonth)->pluck('total')) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nouveaux contacts',
                    data: totals,
                    backgroundColor: '#007bffbb',
                    borderColor: '#007bff',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { drawBorder: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection