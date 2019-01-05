@extends('layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h3>Modifier un Utilisateur</h3>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
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
            <label>Droits</label>
            <select class="browser-default" name="admin">
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select><br>
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
