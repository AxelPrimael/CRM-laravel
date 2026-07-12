@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 30px auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .form-header {
        margin-bottom: 25px;
        border-bottom: 2px solid #f4f6f9;
        padding-bottom: 15px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 15px;
        transition: all 0.2s;
    }

    input:focus, select:focus {
        border-color: #28a745; /* Vert pour la création */
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.1);
    }

    /* Gestion des erreurs */
    .is-invalid {
        border-color: #dc3545 !important;
    }

    .error-feedback {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
        font-weight: 500;
    }

    /* Boutons */
    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn-submit {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        flex: 2;
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #218838;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 6px;
        text-align: center;
        flex: 1;
    }

    .required::after {
        content: " *";
        color: #dc3545;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 style="margin:0; font-size: 24px;">➕ Ajouter un utilisateur</h1>
        <p style="color: #666; margin-top: 5px;">Remplissez les informations pour créer un nouveau compte.</p>
    </div>

    <form method="POST" action="/users">
        @csrf

        <!-- NOM -->
        <div class="form-group">
            <label for="name" class="required">Nom complet</label>
            <input type="text" 
                   name="name" 
                   id="name" 
                   placeholder="Ex: Jean Dupont"
                   class="@error('name') is-invalid @enderror"
                   value="{{ old('name') }}" 
                   required>
            @error('name')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- EMAIL -->
        <div class="form-group">
            <label for="email" class="required">Adresse Email</label>
            <input type="email" 
                   name="email" 
                   id="email" 
                   placeholder="exemple@domaine.com"
                   class="@error('email') is-invalid @enderror"
                   value="{{ old('email') }}" 
                   required>
            @error('email')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

        <!-- MOT DE PASSE -->
        <div class="form-group">
            <label for="password" class="required">Mot de passe</label>
            <input type="password" 
                   name="password" 
                   id="password" 
                   class="@error('password') is-invalid @enderror"
                   required>
            @error('password')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="required">Confirmer le mot de passe</label>
            <input type="password" 
                   name="password_confirmation" 
                   id="password_confirmation" 
                   required>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

        <!-- RÔLE -->
        <div class="form-group">
            <label for="role" class="required">Attribuer un rôle</label>
            <select name="role" id="role" class="@error('role') is-invalid @enderror">
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Choisir un rôle...</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <div class="error-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="btn-group">
            <a href="/users" class="btn-back">Annuler</a>
            <button type="submit" class="btn-submit">Créer l'utilisateur</button>
        </div>
    </form>
</div>
@endsection