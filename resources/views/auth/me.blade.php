@extends('base')

@section('title', 'Me | Conceptic User Mgmt')

@if(session('succès'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{ session('succès') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
@endif

@section('content')

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Bienvenue chez Conceptic.io, <b>{{ $user->name }}</b></h2>
            <div class="dropdown">
                <img src="images/default_avatar.jpeg" alt="Profil" class="rounded-circle" width="50" height="50">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Menu
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a href="{{ route('about') }}" class="dropdown-item">À propos</a></li>
                    <li><a href="#" class="dropdown-item">Paramètres</a></li>
                    <li>
                        <a href="#"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"
                            class="dropdown-item text-danger">
                            Se déconnecter
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            {{-- Nom et prenom --}}
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Nom et Prénom(s)</h5>
                        <p>{{ $user->name }}</p>
                        <a href="{{ route('update.show', ['user' => $user->id, 'field' => 'name']) }}">
                            <button class="btn btn-outline-primary">Modifier</button>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Adresse mail</h5>
                        <p>{{ $user->email }}</p>
                         <a href="{{ route('update.show', ['user' =>$user->id, 'field' => 'email']) }}">
                            <button class="btn btn-outline-primary">Modifier</button>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Rôle --}}
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>Rôle</h5>
                        <p> {{ $user->role }}</p>
                        <small class="text-muted">Non modifiable</small>
                    </div>
                </div>
            </div>

            {{-- Statut --}}
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Statut</h5>
                        <p>{{ $user->status }}</p>
                         <a href="{{ route('update.show', ['user' => $user->id, 'field' => 'status']) }}">
                            <button class="btn btn-outline-primary ">Modifier</button>
                        </a>
                    </div>
                    {{-- Point de couleur selon statut --}}
                    @php
                        $colors = [
                            'active' => 'bg-success',
                            'inactive' => 'bg-primary',
                            'suspended' => 'bg-warning',
                            'deleted' => 'bg-danger'
                        ];
                    @endphp

                    <span class=" mt-4 badge rounded-pill {{ $colors[$user->status] ?? 'bg-secondary' }}">&nbsp;</span>

                </div>
            </div>
        </div>
    </div>

    {{-- Supprimer compte --}}
    <div class="mt-4">
        <form method="post" action="#">
            @csrf
            <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous supprimer votre compte ? Cette action est irréversible.')">
                Supprimer mon compte
            </button>
        </form>
    </div>
@endsection

@section('footer')
    &copy; 2026 conceptic.io. Tout droits réservés
@endsection
