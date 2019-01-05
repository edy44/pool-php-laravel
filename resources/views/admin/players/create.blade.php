@extends('layouts.admin')

@section('content')

    <h3>Créer un Joueur</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('players.store') }}">
        @csrf
        <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" name="name">
        </div>
        <div class="form-group">
            <label>Equipe</label>
            <select class="browser-default" name="team_id">
                <?php foreach ($teams as $team): ?>
                <option value="{{ $team->id }}">{{ $team->name }}</option>
                <?php endforeach; ?>
            </select><br>
        </div>
        <div class="form-group">
            <label>Année de Naissance</label>
            <input type="text" class="form-control" name="birthdate">
        </div>
        <div class="form-group">
            <label>Rôle</label>
            <input type="text" class="form-control" name="role">
        </div>
        <div class="form-group">
            <label>Buts</label>
            <input type="text" class="form-control" name="goal">
        </div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>

@endsection
