<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard CRM</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            margin:0;
            padding:20px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        h1{
            margin-bottom:5px;
        }

        h2{
            color:#555;
            font-weight:normal;
            margin-top:0;
        }

        /* CARDS */
        .cards{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:15px;
            margin:20px 0;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
            transition:0.2s;
        }

        .card:hover{
            transform: translateY(-3px);
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
        }

        .card h3{
            margin:0;
            font-size:14px;
            color:gray;
        }

        .card p{
            font-size:22px;
            margin:10px 0 0;
            font-weight:bold;
        }
.grid{
    display:grid;
    grid-template-columns: 2fr 1fr;
    gap:15px;
}
        /* SECTION */
        .section{
            background:white;
            padding:20px;
            border-radius:12px;
            margin-bottom:20px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .contact{
            display:flex;
            gap:15px;
            align-items:center;
        }

        .avatar{
            width:70px;
            height:70px;
            border-radius:50%;
            object-fit:cover;
            background:#ddd;
        }

        a{
            display:inline-block;
            margin-top:10px;
            color:#007bff;
            text-decoration:none;
        }

        a:hover{
            text-decoration:underline;
        }

        @media(max-width:768px){
            .cards{
                grid-template-columns:1fr;
            }
                .grid{
        grid-template-columns:1fr;
    }
        }
    </style>
</head>

<body>

<div class="container">
    
@role('Super Admin')

<div>
    <h3>⚙️ Administration</h3>
    <p>{{ $totalAdmins }}</p>

    <a href="/users">
    👥 Gestion utilisateurs
    </a>
</div>

@role('Super Admin')

<li>
<a href="/activities">
📋 Historique
</a>
</li>

@endrole
    <div class="card">
        <h3>⭐ Super Admin</h3>
        <p>{{ $totalSuperAdmins }}</p>
    </div>
@endrole
    <!-- HEADER -->
     
    <h1>📊 Dashboard CRM</h1>
    <h2>Bienvenue {{ $user->name }} 👋</h2>

    <p>Email : {{ $user->email }}</p>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total contacts</h3>
            <p>{{ $totalContacts }}</p>
        </div>

        <div class="card">
            <h3>Emails</h3>
            <p>{{ $emailsCount }}</p>
        </div>

        <div class="card">
            <h3>Téléphones</h3>
            <p>{{ $phonesCount }}</p>
        </div>

    </div>
     <div class="grid">

    <!-- DERNIER CONTACT -->
    <div class="section">
        <h3>🆕 Dernier contact</h3>

        @if($latestContact)
            <div class="contact">

                @if($latestContact->photo)
                    <img class="avatar" src="{{ asset('storage/' . $latestContact->photo) }}">
                @else
                    <img class="avatar" src="https://via.placeholder.com/70">
                @endif

                <div>
                    <p><strong>Nom :</strong> {{ $latestContact->name }}</p>
                    <p><strong>Email :</strong> {{ $latestContact->email }}</p>
                    <p><strong>Téléphone :</strong> {{ $latestContact->phone }}</p>
                </div>

            </div>
        @else
            <p>Aucun contact encore.</p>
        @endif
        
    </div>
    <!-- DROITE : RECENTS -->
    <div class="section">
        <h3>🆕 Contacts récents</h3>

        @if($recentContacts->count())
            <ul style="list-style:none; padding:0;">
                @foreach($recentContacts as $contact)
                    <li style="padding:10px 0; border-bottom:1px solid #eee; display:flex; gap:10px; align-items:center;">

                        @if($contact->photo)
                            <img src="{{ asset('storage/' . $contact->photo) }}" width="40" height="40"
                                 style="border-radius:50%; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/40" width="40" height="40"
                                 style="border-radius:50%;">
                        @endif

                        <div>
                            <strong>{{ $contact->name }}</strong><br>
                            <small style="color:gray;">{{ $contact->email }}</small>
                        </div>

                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun contact récent.</p>
        @endif
    </div>

     </div>


    

    <!-- CHART -->
    <div class="section">
        <h3>📊 Contacts par mois</h3>

        <canvas id="contactsChart"></canvas>
    </div>
    
@role('Super Admin')
    <a href="/contacts">Voir les contacts →</a>
    
@endrole
</div>
@role('Super Admin')

<div class="section">
    <h3>⚙️ Administration</h3>

    <p>
        Vous êtes Super Admin.
        Vous pouvez gérer les utilisateurs et les permissions.
    </p>
</div>

@endrole
<script>
const ctx = document.getElementById('contactsChart').getContext('2d');

const data = {
    labels: {!! json_encode(collect($contactsPerMonth)->pluck('month')) !!},
    datasets: [{
        label: 'Contacts',
        data: {!! json_encode(collect($contactsPerMonth)->pluck('total')) !!},
        borderWidth: 2
    }]
};

new Chart(ctx, {
    type: 'bar',
    data: data
});
</script>

</body>
</html>