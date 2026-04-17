@extends('base')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="m-4 text-center">Bienvenue chez Conceptic.io, <span class="text-primary">{{ $user->name }}</span></h2>
    <div class="dropdown">
        <img src="images/default_avatar.jpeg" alt="Profil" class="rounded-circle border" width="50" height="50">
        <button class="btn btn-outline-secondary dropdown-toggle ms-2" type="button" data-bs-toggle="dropdown">
            Menu
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a href="{{ route('about') }}" class="dropdown-item">À propos</a></li>
            <li><a href="#" class="dropdown-item">Paramètres</a></li>
            <li>
                <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Se déconnecter
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="post">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Tableau de bord</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Utilisateurs actifs</h5>
                        <h2 class="fw-bold">{{ $stats['users']['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-danger">
                    <div class="card-body text-center">
                        <h5 class="card-title text-danger">Utilisateurs supprimés</h5>
                        <h2 class="fw-bold">{{ $stats['users']['deleted'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Total historique</h5>
                        <h2 class="fw-bold">{{ $stats['users']['total_historical'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="alert alert-info">
                <strong>Créés aujourd'hui :</strong> {{ $stats['activity']['created_today'] }} <br>
                <strong>Modifiés aujourd'hui :</strong> {{ $stats['activity']['updated_at'] }} <br>
                <strong>Taux de rétention :</strong> {{ $stats['ratios']['retention_rate'] }}
            </div>
        </div>
    </div>
@endsection

@section('list')
<div class="container-fluid mt-5">
    <h2 class="mb-4">Liste des utilisateurs</h2>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $user->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <!-- Option 1: Boutons visibles -->
                        <a href="{{ route('update.process', ['user' => $user->id, 'field' => 'name']) }}" class="btn btn-sm btn-outline-primary me-1">Changer nom</a>
                        <a href="{{ route('update.process', ['user' => $user->id, 'field' => 'status']) }}" class="btn btn-sm btn-outline-warning me-1">Changer status</a>

                        <form action="{{ route('delete.process', ['id' => $user->id]) }}" method="post" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
