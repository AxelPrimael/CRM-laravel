@extends('layouts.app')

@section('content')

<h1>Ajouter un contact</h1>
@if ($errors->any())

    <div style="color:red;">

        <ul>

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form method="POST" action="/contacts" enctype="multipart/form-data">
    @csrf

    <!-- PREVIEW IMAGE -->
    <img id="preview" src="https://via.placeholder.com/80" width="80"
         style="display:block; margin-bottom:10px; border-radius:8px;">

    <div>
        <label>Nom</label>
        <input type="text" name="name">
    </div>

    <br>

    <div>
        <label>Email</label>
        <input type="email" name="email">
    </div>

    <br>

    <div>
        <label>Téléphone</label>
        <input type="text" name="phone">
    </div>

    <br>

    <div>
        <label>Photo</label>
        <input type="file" name="photo" onchange="previewImage(event)">
    </div>

    <br>

    <button type="submit">Enregistrer</button>

</form>


<!-- JS PREVIEW IMAGE -->
<script>
function previewImage(event) {
    const input = event.target;

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>


@endsection