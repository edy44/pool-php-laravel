@extends('layouts.default')

@section('content')

    <h4>Compte-rendu du Match</h4>

    <h5>Informations principales</h5>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">Match</th>
            <th scope="col">Lieu</th>
            <th scope="col">Vainqueur</th>
            <th scope="col">Score</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $match->date }}</td>
                <td>{{ $match->time }}</td>
                <td><img class="rounded" src="{{asset('images/'.$match->flag_1)}}" alt="{{ $match->team_1 }}">
                    {{ $match->team_1 }} VS {{ $match->team_2 }}
                    <img src="{{asset('images/'.$match->flag_2)}}" class="rounded" alt="{{ $match->team_2 }}"></td>
                <td>{{ $match->emplacement }}</td>
                <th>{{ $match->winner }}</th><th>{{ $match->score }}</th>
            </tr>
        </tbody>

    </table>

    <h5>Détails du Matchs</h5>
    <br>
    <h6>Météo</h6>
    <p>{{ $match->weather }}</p>
    <br>
    <h6>Cartons</h6>
    <p>{{ $match->faults }}</p>
    <br>
    <h6>Actions principales</h6>
    <p>{{ $match->actions }}</p>

@endsection