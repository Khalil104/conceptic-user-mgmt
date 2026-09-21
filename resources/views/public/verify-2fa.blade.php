@extends('base')

@section('title', 'Vérification 2FA | Conceptic User Management')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 8ovh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <h4 class="text-center mb-4">Vérification en deux étapes</h4>
            <p class="text-center text-muted">Entrez le code reçu par e-mail</p>
             @if ($errors->any())
                 <div class="alert alert-danger">
                    {{ $errors->first() }}
                 </div>
             @endif
            <form action="{{ route('verify-2fa.process') }}" method="post">
                @csrf
                {{-- user_id --}}
                <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                {{-- Code de vérification --}}
                <div class="mb-3">
                    <label for="code" class="form-label">Code de vérification</label>
                    <input type="text" name="code" id="code"class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required autofocus/>
                    <p class="mt-2"><small>Entrez le code à 6 chiffres reçu par mail !</small></p>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- Button --}}
                <div class="d-grid">
                    <button type ="submit" class="btn btn-success">Valider</button>
                 </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    &copy; 2026 conceptic.io. Tout droits réservés.
@endsection

