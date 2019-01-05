@extends('layouts.admin')

@section('content')

    <h3>Historique des paris sur le site</h3>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Utilisateur</th>
            <th scope="col">Match</th>
            <th scope="col">Pronostics</th>
            <th scope="col">Cote Bets</th>
            <th scope="col">Mise</th>
            <th scope="col">Paris</th>
            <th scope="col">Gain</th>
        </tr>
        </thead>

        <tbody>
        @foreach($bets as $bet)
            <tr>
                <td>{{ $bet->bet_date }} à {{ $bet->bet_time }}</td>
                <td>{{ $bet->user_id }}</td>
                <td><img class="rounded" src="{{asset('images/'.$bet->flag1)}}" alt="{{ $bet->team1 }}">
                    {{ $bet->team1 }}
                    @if($bet->score)
                        {{ $bet->score }}
                    @else
                        VS
                    @endif
                    {{$bet->team2}}
                    <img class="rounded" src="{{asset('images/'.$bet->flag2)}}" alt="{{ $bet->team2 }}">
                    le {{ $bet->match_date }} à {{ $bet->match_time }}
                </td>
                <td>{{ $bet->bet_winner }}</td>
                <td>{{ $bet->cote_bets }}</td>
                <td>{{ $bet->mise }}</td>
                <td>@if($bet->win_bets)
                        <span class="badge badge-success">Gagné</span></h3>
                    @elseif($bet->score)
                        <span class="badge badge-danger">Perdu</span></h3>
                    @else
                        <span class="badge badge-warning">A venir</span></h3>
                    @endif
                </td>
                <td>@if(!$bet->gain)
                        -
                    @else
                        {{$bet->gain}}
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>

    @endsection