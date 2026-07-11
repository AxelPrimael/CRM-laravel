@if(session('success'))
    <p style="color:green;">
        {{ session('success') }}
    </p>
@endif
<h1>Liste des contacts</h1>

@can('contact.create')
    <a href="/contacts/create">
        ➕ Ajouter un contact
    </a>
@endcan

<hr>

@foreach($contacts as $contact)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
@if($contact->photo)
    <img src="{{ asset('storage/' . ltrim($contact->photo, '/storage/')) }}" width="80">
@else
    <img src="https://via.placeholder.com/80" width="80">
@endif
        <strong>Nom :</strong> {{ $contact->name }} <br>
        <strong>Email :</strong> {{ $contact->email }} <br>
        <strong>Téléphone :</strong> {{ $contact->phone }} <br><br>

@can('contact.edit')
    <a href="/contacts/{{ $contact->id }}/edit">
        ✏️ Modifier
    </a>
@endcan

@can('contact.delete')

        <form method="POST" action="/contacts/{{ $contact->id }}" style="display:inline;">
            @csrf
            @method('DELETE')

            <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce contact ?')">
                  🗑 Supprimer
            </button>
        </form>
@endcan
    </div>
@endforeach

<div style="margin-top:20px;">
    {{ $contacts->links() }}
</div>