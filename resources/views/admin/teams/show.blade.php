@extends('layouts.admin')

@section('content')

    <h3><img class="rounded" alt={{$players[0]->flag}} src="{{asset('images/'.$players[0]->flag)}}"> Equipe {{ $players[0]->team }}</h3>
    <p>Pays {{ $players[0]->country }}</p>

    <h5>Statistiques</h5>
    <p>Nombre de Joueurs : {{ $stat_team->players }}</p>
    <p>Nombre de Matchs Joués : {{ $stat_team->matches }}</p>
    <p>Nombre de Victoires : {{ $stat_team->win }}</p>
    <p>Nombre de Matchs Nuls : {{ $stat_team->nul }}</p>
    <p>Nombre de Défaites : {{ $stat_team->loose }}</p>

    <h5>Joueurs</h5>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Age</th>
            <th scope="col">Rôle</th>
            <th scope="col">Buts</th>
        </tr>
        </thead>
        <tbody>
        @foreach($players as $player)
            <tr>
                <td>{{ $player->name }}</td>
                <td>{{ $player->birthdate }}</td>
                <td>{{ $player->role }}</td>
                <td>{{ $player->goal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
