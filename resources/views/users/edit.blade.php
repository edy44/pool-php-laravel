@extends('layouts.default')

@section('content')

    <h3>Modifier mon Profil</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h5>
        Solde de mon Compte :
        @if(!$user->balance)
            0,00 €
        @else
            {{ $user->balance }} €
        @endif
    </h5>

    <form method="POST" action="{{ route('profil.update', $user->id) }}">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
        </div>
        <div class="form-group">
            <label>Ajouter sur mon compte</label>
            <input type="text" class="form-control" name="balance" value="">
        </div>
        <div class="form-group">
            <label>Mot de Passe</label>
            <input type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label>Confirmation Mot de Passe</label>
            <input type="password" class="form-control" name="password_confirm">
        </div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>

@endsection
