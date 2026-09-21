@extends('base')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">À Propos</h2>

        {{-- Message principal --}}
        <div class="alert alert-info">
            <p class="text-center">Vue about accessible</p>
        </div>

        {{-- Description de l'application --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Description de l'application</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nom  : </strong>Conceptic-user-mgmt</li>
                    <li class="list-group-item"><strong>Version  : </strong>1.0.0</li>
                    <li class="list-group-item"><strong>Cadre  : </strong>Stage Académique</li>
                </ul>
            </div>
        </div>

        {{-- Stack --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Stack Technique</h5>
                <p><strong>Langage  : </strong> Php 8.4</p>
                <p><strong>Framework  : </strong>Laravel 11</p>
                <p><strong>Dev env  : </strong> Linux</p>
            </div>
        </div>

        {{-- Développeur --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Développeur</h5>
                <p><strong>Nom  : </strong>Abdoul Rachid BISSARE</p>
                <p><strong>Spécialité  : </strong>Full Stack Web Developer</p>
                <p><strong>Email  : </strong>rhdkhalil104@gmail.com</p>
            </div>
        </div>

        @section('footer')
            &copy; 2026 conceptic.io. Tout droits réservés
        @endsection
    </div>
@endsection
