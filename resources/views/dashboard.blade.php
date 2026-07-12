@extends('layouts.app')

@section('content')

<style>
body{
    font-family: Arial;
    background:#f4f6f9;
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
    grid-template-columns:2fr 1fr;
    gap:15px;
}


.section{
    background:white;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
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


<div class="container">


{{-- ADMIN --}}
@role('Super Admin')

<div class="cards">

    <div class="card">
        <h3>⚙️ Administrateurs</h3>
        <p>{{ $totalAdmins }}</p>

        <a href="/users">
            👥 Gestion utilisateurs
        </a>
    </div>


    <div class="card">
        <h3>⭐ Super Admin</h3>
        <p>{{ $totalSuperAdmins }}</p>
    </div>


</div>


<div class="section">

<a href="/activities">
📋 Historique
</a>

</div>


@endrole



<!-- HEADER -->

<h1>📊 Dashboard CRM</h1>

<h2>
Bienvenue {{ $user->name }} 👋
</h2>


<p>
Email : {{ $user->email }}
</p>



<!-- STATISTIQUES -->

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

<img class="avatar"
src="{{ asset('storage/'.$latestContact->photo) }}">

@else

<img class="avatar"
src="https://via.placeholder.com/70">

@endif



<div>

<p>
<strong>Nom :</strong>
{{ $latestContact->name }}
</p>


<p>
<strong>Email :</strong>
{{ $latestContact->email }}
</p>


<p>
<strong>Téléphone :</strong>
{{ $latestContact->phone }}
</p>


</div>


</div>


@else

<p>Aucun contact encore.</p>

@endif


</div>






<!-- CONTACTS RECENTS -->

<div class="section">


<h3>🆕 Contacts récents</h3>



@if($recentContacts->count())


<ul style="list-style:none;padding:0;">


@foreach($recentContacts as $contact)


<li style="
padding:10px 0;
border-bottom:1px solid #eee;
display:flex;
gap:10px;
align-items:center;
">


@if($contact->photo)

<img src="{{ asset('storage/'.$contact->photo) }}"
width="40"
height="40"
style="border-radius:50%;object-fit:cover;">

@else

<img src="https://via.placeholder.com/40"
width="40"
height="40"
style="border-radius:50%;">

@endif


<div>

<strong>
{{ $contact->name }}
</strong>

<br>

<small>
{{ $contact->email }}
</small>


</div>


</li>


@endforeach


</ul>



@else

<p>Aucun contact récent.</p>


@endif


</div>


</div>





<!-- GRAPH -->

<div class="section">


<h3>📊 Contacts par mois</h3>


<canvas id="contactsChart"></canvas>


</div>





@role('Super Admin')

<a href="/contacts">
Voir les contacts →
</a>

@endrole




@role('Super Admin')

<div class="section">

<h3>⚙️ Administration</h3>


<p>
Vous êtes Super Admin.
Vous pouvez gérer les utilisateurs et les permissions.
</p>


</div>

@endrole





</div>


<script>
const chartElement = document.getElementById('contactsChart');

if (chartElement) {

    const ctx = chartElement.getContext('2d');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json(collect($contactsPerMonth)->pluck('month')),

            datasets: [
                {
                    label: 'Contacts',
                    data: @json(collect($contactsPerMonth)->pluck('total')),
                    borderWidth: 2
                }
            ]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: true
                }

            },

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        }

    });

}
</script>


@endsection