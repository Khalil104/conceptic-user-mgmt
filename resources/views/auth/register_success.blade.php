@extends('base')

@section('title', 'Succès | Conceptic-user-mgmt')

@section('content')
    <div class="container mt-5">
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <h4 class="alert-heading">Bienvenue sur Conceptic.io</h4>
            <p>Votre inscription a été prise en compte avec succès.</p>
            <p>Consultez vos mails et cliquez sur le lien reçu pour activer votre compte</p>
            <hr>
            <p class="mb-0">Merci de rejoindre notre communauté !</p>
            <button  type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
@endsection

@section('footer')
    &copy; 2026 conceptic.io. Tout droits réservés
@endsection
