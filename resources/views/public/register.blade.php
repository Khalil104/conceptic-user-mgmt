@extends('base')

@section('title', 'S\'inscrire | Conceptic User Management')


@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height:8ovh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width:500px;">
            <h4 class="text-center mb-4">Inscrivez-vous maintenant !</h4>
             <form action="{{ route('register.process') }}" method="post">
                @csrf

                {{-- Nom --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Nom et prénom(s)</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error("name")
                        <div class="invalid-feeback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="text" id="email"  name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error("email")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Mot de passe --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error("password")
                        <div class="invalid-feeback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Confirmer le mot de passe --}}
                 {{-- <div class="mb-3">
                    <label for="confirm-password" class="form-label">Confirmer le Mot de passe</label>
                    <input type="confirm-password" name="confirm-password" id="confirm-password" class="form-control @error('confirm-password') is-invalid @enderror" required>
                    @error("confirm-password")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}
                
                {{-- Rôle --}}
                <div class="mb-3">
                    <label for="role" class="form-label">Choisissez votre rôle</label>
                    <select name="role" id="role" class="form-select @error('role') is-invalide @enderror" required>
                        <option value="" disabled selected>-- Selectionnez --</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}"> Administrateur</option>
                    </select>
                    @error("role")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Choisissez votre statut</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="" disabled selected>--Selectionnez --</option>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : ''}}>Actif</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                        <option value="suspended" {{ old('status') == 'inactive' ? 'selected' : '' }}>Suspendu</option>
                        <option value="deleted" {{ old('status') == 'inactive' ? 'selected' : '' }}>Supprimé</option>
                    </select>
                    @error("role")
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type ="submit" class="btn btn-primary">Créer mon compte</button>
                </div>
                <center><p class="mt-2"><small>Déjà un compte ?  <a href="{{ route('login.show') }}">Connectez-vous</a></small></p></center>
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
 
   
