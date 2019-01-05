@extends('layouts.admin')

@section('content')

    <h3>Liste des Joueurs</h3>

    <a href="{{ url('admin/players/create') }}" role="button" class="btn btn-primary" aria-disabled="true">Nouveau Joueur</a>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Age</th>
            <th scope="col">Rôle</th>
            <th scope="col">Equipe</th>
            <th scope="col">Buts</th>
            <th scope="col">Actions</th>
            <th scope="col">Stats Equipe</th>
        </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
                <td>{{ $player->name }}</td>
                <td>{{ $player->birthdate }}</td>
                <td>{{ $player->role }}</td>
                <td>{{ $player->team }}</td>
                <td>{{ $player->goal }}</td>
                <td>
                    <a href="{{ route('players.edit', $player->id) }}" role="button" class="btn btn-primary">Modifier</a>
                    <form action="{{ route('players.destroy', $player->id) }}" method="POST">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"
                                onclick="return confirm('Voulez-vous vraiment confirmer la suppression ?')">
                            Supprimer</button>
                    </form>
                </td>
                <td>
                    @if($player->team_id != 1)
                        <a href="{{ route('players.show', $player->team_id) }}" role="button" class="btn btn-primary">Voir Equipe</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
