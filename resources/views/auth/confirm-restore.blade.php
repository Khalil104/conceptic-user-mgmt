@extends('base')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Confirmer la restauration</h2>

    {{-- Formulaire de restauration --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-3">
               Entrez le mot de passe reçu par mail
                Cette action réactivera votre profil désactivé.
            </p>

            <form method="POST" action="{{ route('confirm-restore.process') }}">
                @csrf

                <input type="hidden" name="email" value="{{ session('restore_email') }}">

                {{-- Code de restauration  --}}
                <div class="mb-3">
                    <label for="code" class="form-label">Code de restauration</label>
                    <input type="text" name="code" id="code" class="form-control" placeholder="Entrez le code reçu par email">
                </div>

                <button type="submit" class="btn btn-primary">Confirmer la restauration</button>
            </form>
        </div>
    </div>

    {{-- Footer --}}
    @section('footer')
        © 2026 Conceptic.io. Tous droits réservés.
    @endsection
</div>
@endsection
