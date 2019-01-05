@extends('layouts.default')

@section('content')

    <h4>Matchs à Venir</h4>

    <div class="btn-group" role="group">
        <a href="{{ route('matches') }}" role="button" class="btn btn-primary btn-green">Matchs à venir</a>
        <a href="{{ route('matches', 'finish') }}" role="button" class="btn btn-primary btn-green">Matchs terminés</a>
    </div>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Heure</th>
                <th scope="col">Match</th>
                <th scope="col">Lieu</th>
                <th scope="col">Cote 1</th>
                <th scope="col">Cote Match nul</th>
                <th scope="col">Cote 2</th>
                @if($status == 'finish')
                    <th scope="col">Vainqueur</th>
                    <th scope="col">Score</th>
                    <th scope="col">Stats</th>
                @else
                    <th scope="col">Pariez</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($matches as $match)
                <tr>
                    <td>{{ $match->date }}</td>
                    <td>{{ $match->time }}</td>
                    <td><img class="rounded" src="{{asset('images/'.$match->flag_1)}}" alt="{{ $match->team_1 }}">
                        {{ $match->team_1 }} VS {{ $match->team_2 }}
                        <img src="{{asset('images/'.$match->flag_2)}}" class="rounded" alt="{{ $match->team_2 }}"></td>
                    <td>{{ $match->emplacement }}</td>
                    <td>{{ $match->cote_team_1 }}</td>
                    <td>{{ $match->cote_match_n }}</td>
                    <td>{{ $match->cote_team_2 }}</td>
                    @if($status == 'finish')
                        <th>{{ $match->winner }}</th>
                        <th>{{ $match->score }}</th>
                        <th><a href="{{ route('show.stats', $match->id) }}" role="button" class="btn btn-info">Stats</a></th>
                    @else
                        <td>
                            <a href="{{ route('new-bet', $match->id) }}" role="button" class="btn btn-primary btn-green">Pariez !</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>

    </table>

@endsection
