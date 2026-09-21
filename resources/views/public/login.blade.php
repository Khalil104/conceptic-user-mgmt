@extends('base')

@section('title', 'Se connecter | Conceptic User Management')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:8ovh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
        <h4 class="text-center mb-4">Entrez vos identifiants</h4>
        <form action="{{ route('login.process') }}" method="post">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error("email")
               <div class="invalid-feeback"> {{ $message }}</div>
            @enderror
        </div>

        {{-- Mot de passe --}}
       <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password"  name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
            @error("password")
                <div class="invalid-feeback">{{ $message }}</div>
            @enderror
       </div>

       {{-- Buttton --}}
        <div class="d-grid">
            <button type ="submit" class="btn btn-primary">Se connecter</button>
        </div>
        <center><p class="mt-2"><small>Pas de compte ?  <a href="{{ route('register.show') }}">Inscrivez-vous</a></small></p></center>
    </form>
    </div>
</div>
@endsection

@section('back')
    <div class="d-flex justify-content-center mt-5">  
       <a href="{{ route('index') }}"> <button class="btn btn-outline-primary ">Retourner à l'accueil</button></a>
    </div>
@endsection

@section('footer')
    &copy; 2026 conceptic.io. Tous droits réservés.
@endsection
