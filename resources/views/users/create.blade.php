<h1>➕ Ajouter un utilisateur</h1>


@if($errors->any())

<div style="color:red">

<ul>

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif



<form method="POST" action="/users">

@csrf


<div>

<label>Nom</label>

<input 
type="text" 
name="name"
value="{{ old('name') }}"
>

</div>


<br>


<div>

<label>Email</label>

<input 
type="email" 
name="email"
value="{{ old('email') }}"
>

</div>


<br>


<div>

<label>Mot de passe</label>

<input 
type="password" 
name="password"
>

</div>


<br>


<div>

<label>Confirmer le mot de passe</label>

<input 
type="password" 
name="password_confirmation"
>

</div>


<br>


<div>

<label>Rôle</label>


<select name="role">


@foreach($roles as $role)

<option value="{{ $role->name }}">

{{ $role->name }}

</option>


@endforeach


</select>


</div>


<br>


<button type="submit">

Créer l'utilisateur

</button>


</form>