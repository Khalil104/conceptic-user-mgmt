@extends('base')
@section('content')

    <div class="alert alert-warning">
        Votre compte est désactivé. Voulez-vous le restaurer ?
    </div>

    <form action="{{ route('account-disabled.process') }}" method="post">
        @csrf
        <button type="submit" name="choice" value="yes" class="btn btn-success">Oui, restaurer</button>
        <button type="submit" name="choice" value="no" class="btn btn-danger">Non, retour à l'accueil</button>
    </form>
@endsection