@extends('layouts.default')

@section('content')
<div class="row">
    <div class="card-deck mb-3 text-center">
        @foreach($teams as $team)
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal"><img class="rounded" src="{{asset('images/'.$team->flag)}}" alt="{{ $team->name }}"> {{ $team->name }}</h4>
                    <em>Pays {{ $team->country }}</em>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        @foreach($players as $player)
                            @if( $team->id == $player->team_id)
                                <li>{{ $player->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                    <a href="{{ route('teams.stats', $team->id) }}" role="button" class="btn btn-info">Stats</a>
                    <a href="{{ route('matches', ['incoming', $team->id]) }}" role="button" class="btn btn-primary btn-green">Pariez !</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
