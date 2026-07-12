@extends('layouts.app')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .card-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    th {
        background-color: #f8f9fa;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        padding: 15px;
        text-align: left;
        border-bottom: 2px solid #edf2f7;
    }

    td {
        padding: 15px;
        vertical-align: middle;
        border-bottom: 1px solid #edf2f7;
        font-size: 14px;
        color: #333;
    }

    tr:hover {
        background-color: #fcfcfc;
    }

    /* BADGES */
    .badge {
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-role { background: #e2e8f0; color: #4a5568; }
    .badge-active { background: #c6f6d5; color: #22543d; }
    .badge-inactive { background: #fed7d7; color: #822727; }

    /* BOUTONS */
    .btn {
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        cursor: pointer;
        transition: 0.2s;
    }
    .btn-edit { background: #ebf4ff; color: #3182ce; }
    .btn-edit:hover { background: #bee3f8; }
    
    .btn-delete { background: #fff5f5; color: #e53e3e; }
    .btn-delete:hover { background: #fed7d7; }

    .btn-add { background: #3182ce; color: white; }
    .btn-add:hover { background: #2b6cb0; }

    .alert-success {
        background: #c6f6d5;
        color: #22543d;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 5px solid #38a169;
    }

    .text-muted { color: #a0aec0; font-size: 12px; }
</style>

<div class="container-fluid" style="padding: 20px;">

    <!-- MESSAGE DE SUCCÈS -->
    @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="page-header">
        <div>
            <h1 style="margin:0;">👥 Gestion des utilisateurs</h1>
            <p style="color:gray; margin: 5px 0 0;">Liste exhaustive des membres de l'équipe et leurs accès.</p>
        </div>
        <a href="/users/create" class="btn btn-add">
            ➕ Nouvel utilisateur
        </a>
    </div>

    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th>Nom & Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Dernière connexion</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $user->name }}</div>
                        <div class="text-muted">{{ $user->email }}</div>
                    </td>
                    
                    <td>
                        @if($user->roles->count())
                            <span class="badge badge-role">{{ $user->roles->first()->name }}</span>
                        @else
                            <span class="text-muted">Aucun rôle</span>
                        @endif
                    </td>

                    <td>
                        @if($user->status)
                            <span class="badge badge-active">🟢 Actif</span>
                        @else
                            <span class="badge badge-inactive">🔴 Inactif</span>
                        @endif
                    </td>

                    <td>
                        @if($user->last_login_at)
                            <div>{{ $user->last_login_at->format('d/m/Y H:i') }}</div>
                            <div class="text-muted">{{ $user->last_login_at->diffForHumans() }}</div>
                        @else
                            <span class="text-muted">Jamais connecté</span>
                        @endif
                    </td>

                    <td style="text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="/users/{{ $user->id }}/edit" class="btn btn-edit">
                                ✏️ Modifier
                            </a>

                            <form method="POST" action="/users/{{ $user->id }}" onsubmit="return confirm('Attention : Cette action est irréversible. Supprimer {{ $user->name }} ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">
                                    🗑 Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 50px; color: gray;">
                        Aucun utilisateur trouvé dans la base de données.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection