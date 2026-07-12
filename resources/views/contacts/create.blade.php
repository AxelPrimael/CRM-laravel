@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 30px auto;
        padding: 0 15px;
    }

    .card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border: none;
    }

    .form-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .form-header h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 5px;
    }

    /* Styles des champs */
    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #555;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    /* Style spécifique pour la photo */
    .avatar-upload {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 25px;
    }

    #preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #f8f9fa;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        margin-bottom: 10px;
        background-color: #eee;
    }

    /* Boutons */
    .btn-submit {
        background: #007bff;
        color: white;
        border: none;
        padding: 14px;
        width: 100%;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 16px;
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #0056b3;
    }

    .btn-back {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-back:hover {
        text-decoration: underline;
    }

    /* Messages d'erreur */
    .error-text {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<div class="form-container">
    <div class="card">
        <div class="form-header">
            <h1>➕ Ajouter un contact</h1>
            <p style="color:gray;">Créez une nouvelle fiche de contact CRM</p>
        </div>

        <form method="POST" action="/contacts" enctype="multipart/form-data">
            @csrf

            <!-- APERÇU ET PHOTO -->
            <div class="avatar-upload">
                <img id="preview" src="https://ui-avatars.com/api/?name=Contact&background=random&size=128" alt="Aperçu">
                <label for="photo" style="cursor: pointer; color: #007bff; font-size: 14px;">Changer la photo</label>
                <input type="file" name="photo" id="photo" onchange="previewImage(event)" style="display: none;" accept="image/*">
                @error('photo')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <!-- NOM -->
            <div class="form-group">
                <label for="name">Nom complet</label>
                <input type="text" name="name" id="name" 
                       class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                       value="{{ old('name') }}" placeholder="ex: Jean Dupont">
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <!-- EMAIL -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input type="email" name="email" id="email" 
                       class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                       value="{{ old('email') }}" placeholder="jean@exemple.com">
                @error('email')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <!-- TÉLÉPHONE -->
            <div class="form-group">
                <label for="phone">Numéro de téléphone</label>
                <input type="text" name="phone" id="phone" 
                       class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                       value="{{ old('phone') }}" placeholder="+33 6 00 00 00 00">
                @error('phone')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">💾 Enregistrer le contact</button>
            
            <a href="/contacts" class="btn-back">← Retour à la liste</a>
        </form>
    </div>
</div>

<script>
/**
 * Gère l'aperçu de l'image en temps réel
 */
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection