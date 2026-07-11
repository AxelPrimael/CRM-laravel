<h1>✏️ Modifier utilisateur</h1>


<form method="POST" action="/users/{{ $user->id }}">

@csrf

@method('PUT')


<label>Nom</label>

<input 
type="text"
name="name"
value="{{ $user->name }}"
>


<br><br>


<label>Email</label>

<input 
type="email"
name="email"
value="{{ $user->email }}"
>


<br><br>


<label>Nouveau mot de passe</label>

<input 
type="password"
name="password"
>


<br><br>


<label>Confirmation mot de passe</label>

<input 
type="password"
name="password_confirmation"
>


<br><br>


<label>Rôle</label>


<select name="role">

@foreach($roles as $role)

<option 
value="{{ $role->name }}"
{{ $user->hasRole($role->name) ? 'selected' : '' }}
>

{{ $role->name }}

</option>


@endforeach


</select>


<br><br>

<label>
Statut
</label>


<select name="status">

<option value="1"
{{ $user->status ? 'selected' : '' }}
>
Actif
</option>


<option value="0"
{{ !$user->status ? 'selected' : '' }}
>
Inactif
</option>

</select>

<button>
Enregistrer
</button>


</form>