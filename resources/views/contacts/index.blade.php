@extends('layouts.app')

@section('content')


@if(session('success'))

<p style="color:green;">
    {{ session('success') }}
</p>

@endif



@if($errors->any())

<div style="color:red;">

<ul>

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif



<h1>Liste des contacts</h1>



@can('contact.create')

<a href="{{ route('contacts.create') }}">
    ➕ Ajouter un contact
</a>

@endcan



<hr>



@foreach($contacts as $contact)


<div class="contact-card">


@if($contact->photo)

<img src="{{ asset('storage/'.$contact->photo) }}" width="80">

@else

<img src="https://via.placeholder.com/80" width="80">

@endif



<p>
<strong>Nom :</strong> 
{{ $contact->name }}
</p>


<p>
<strong>Email :</strong> 
{{ $contact->email }}
</p>


<p>
<strong>Téléphone :</strong> 
{{ $contact->phone }}
</p>




@can('contact.edit')

<a href="{{ route('contacts.edit',$contact->id) }}">
    ✏️ Modifier
</a>

@endcan




@can('contact.delete')


<form method="POST" 
action="{{ route('contacts.destroy',$contact->id) }}"
style="display:inline;">

@csrf
@method('DELETE')


<button type="submit"
onclick="return confirm('Voulez-vous vraiment supprimer ce contact ?')">

🗑 Supprimer

</button>


</form>


@endcan



</div>


@endforeach




<div style="margin-top:20px;">

{{ $contacts->links() }}

</div>



@endsection