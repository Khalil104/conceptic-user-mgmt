@extends('base')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Restaurer mon compte</h2>

        {{-- Formulaire de restauration --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="mb-3">
                  Entrez votre adresse mail pour y recevoir le code de vérification.
                </p>

                <form method="POST" action="{{ route('restore-account.process') }}">
                    @csrf
                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer le code</button>
                </form>
            </div>
        </div>

        @section('footer')
            &copy; 2026 conceptic.io. Tout droits réservés
        @endsection
    </div>
@endsection
