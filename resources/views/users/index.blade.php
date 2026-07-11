@if(session('success'))

<p style="color:green">
    {{ session('success') }}
</p>

@endif

<h1>👥 Gestion des utilisateurs</h1>



<table border="1" cellpadding="10">

<tr>
    <th>Nom</th>
    <th>Email</th>
    <th>Rôle</th>
    <th>Action</th>
    <th>
Statut
</th>
<th>
Dernière connexion
</th>
</tr>


@foreach($users as $user)

<tr>

<td>
    {{ $user->name }}
</td>


<td>
    {{ $user->email }}
</td>


<td>

@if($user->roles->count())

    {{ $user->roles->first()->name }}

@else

    Aucun rôle

@endif

</td>


<td>

<a href="/users/{{ $user->id }}/edit">
✏️ Modifier
</a>


<form 
method="POST"
action="/users/{{ $user->id }}"
style="display:inline"
>

@csrf

@method('DELETE')


<button onclick="return confirm('Supprimer cet utilisateur ?')">

🗑 Supprimer

</button>


</form>

</td>
<td>

@if($user->status)

<span style="color:green">
🟢 Actif
</span>

@else

<span style="color:red">
🔴 Inactif
</span>

@endif

</td>
<td>

@if($user->last_login_at)

{{ $user->last_login_at->format('d/m/Y H:i') }}

@else

Jamais connecté

@endif

</td>
</tr>

@endforeach


</table>
<a href="/users/create">
    ➕ Nouvel utilisateur
</a>