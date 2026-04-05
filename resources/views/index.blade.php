@extends('base')

@section('title', 'Accueil')

@section('header')
    <hr>
    <h1 class="lead text-center">Bienvenue chez <a href="https://conceptic.io"><strong>CONCEPTIC.IO</strong></a></h1>
    <hr>
@endsection

@section('content')
    <div class="d-flex justify-content-center gap-3 mt-5">
    <a href="{{ route('login.show') }}" class="btn btn-primary">Se connecter</a>
    <a href="{{ route('register.show') }}" class="btn btn-success">S'inscrire</a>
</div>
@endsection

@section('footer')
    &copy; 2026 conceptic.io. Tous droits réservés.
@endsection
