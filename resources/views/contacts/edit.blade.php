<h1>Modifier un contact</h1>

<form method="POST" action="/contacts/{{ $contact->id }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- PHOTO ACTUELLE --}}
@if($contact->photo)
    <img src="{{ asset('storage/' . ltrim($contact->photo, '/storage/')) }}" width="80">
@else
    <img src="https://via.placeholder.com/80" width="80">
@endif

    <br><br>

    {{-- NOUVELLE PHOTO --}}
    <div>
        <label>Changer photo</label>
        <input type="file" name="photo">
    </div>

    <br>

    <div>
        <label>Nom</label>
        <input type="text" name="name" value="{{ $contact->name }}">
    </div>

    <br>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ $contact->email }}">
    </div>

    <br>

    <div>
        <label>Téléphone</label>
        <input type="text" name="phone" value="{{ $contact->phone }}">
    </div>

    <br>

    <button type="submit">Mettre à jour</button>
</form>