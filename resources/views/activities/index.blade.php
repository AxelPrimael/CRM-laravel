<h1>📋 Historique des actions</h1>


<form method="GET">


<input 
type="text"
name="search"
placeholder="Rechercher une action..."
value="{{ request('search') }}"
>


<select name="user">

<option value="">
Tous les utilisateurs
</option>


@foreach($users as $user)

<option 
value="{{ $user->id }}"
{{ request('user') == $user->id ? 'selected':'' }}
>

{{ $user->name }}

</option>


@endforeach

</select>


<button>
Filtrer
</button>


</form>


<hr>



<table border="1" width="100%">


<tr>

<th>
Utilisateur
</th>

<th>
Action
</th>

<th>
Date
</th>

</tr>



@foreach($activities as $activity)

<tr>

<td>

{{ $activity->causer->name ?? 'Système' }}

</td>


<td>

{{ $activity->description }}

</td>


<td>

{{ $activity->created_at->format('d/m/Y H:i') }}

</td>


</tr>


@endforeach


</table>


{{ $activities->links() }}