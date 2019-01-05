@extends('layouts.admin')

@section('content')

    <h3><img class="rounded" alt={{$players[0]->flag}} src="{{asset('images/'.$players[0]->flag)}}"> Equipe {{ $players[0]->team }}</h3>
    <p>Pays {{ $players[0]->country }}</p>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Age</th>
            <th scope="col">Rôle</th>
            <th scope="col">Buts</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach($players as $player)
            <tr>
                <td>{{ $player->name }}</td>
                <td>{{ $player->birthdate }}</td>
                <td>{{ $player->role }}</td>
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
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
