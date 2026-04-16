@extends('base')

@section('content')
    <div class="container mt-4">
        <h2>Modifier {{  ucfirst($field) }}</h2>

        <form action="{{  route('update.process', [$user->id, $field]) }}", method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="{{ $field }}" class="form-label">{{ ucfirst($field) }}</label>
                    <input type="text"  name="{{ $field }}" id="{{ $field }}" value="{{ $user->$field }}" class="form-control">
                </div>

                <button class="btn btn-primary">
                    Enregistrer
                </button>
        </form>
    </div>
@endsection
