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
        transition: border-color 0.2s;
    }

    input:focus, select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .error-message {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 30px;
    }

    .btn-save {
        background: #007bff;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        flex: 2;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        border-radius: 6px;
        text-align: center;
        flex: 1;
    }

    .btn-save:hover { background: #0056b3; }
    .btn-cancel:hover { background: #5a6268; }

    .password-note {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<div class="form-container">
    <div class="form-header">
        <h1 style="margin:0; font-size: 24px;">✏️ Modifier l'utilisateur</h1>
    </div>

    <form method="POST" action="/users/{{ $user->id }}">
        @csrf
        @method('PUT')

        <!-- NOM -->
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" 
                   name="name" 
                   id="name"
                   class="@error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" 
                   required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- EMAIL -->
        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" 
                   name="email" 
                   id="email"
                   class="@error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" 
                   required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

        <!-- MOT DE PASSE -->
        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input type="password" 
                   name="password" 
                   id="password"
                   class="@error('password') is-invalid @enderror">
            <p class="password-note">Laissez vide pour conserver le mot de passe actuel.</p>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

        <!-- RÔLE -->
        <div class="form-group">
            <label for="role">Rôle utilisateur</label>
            <select name="role" id="role">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" 
                        {{ (old('role') == $role->name || $user->hasRole($role->name)) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- STATUT -->
        <div class="form-group">
            <label for="status">Statut du compte</label>
            <select name="status" id="status">
                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>✅ Actif</option>
                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>🚫 Inactif</option>
            </select>
        </div>

        <div class="btn-group">
            <a href="/users" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-save">Enregistrer les modifications</button>
        </div>
    </form>
</div>
@endsection