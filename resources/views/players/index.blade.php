@extends('layouts.default')

@section('content')
<div class="row">
    <div class="card-deck mb-3 text-center">
        @foreach($players as $player)
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal"><img class="rounded" src="{{asset('images/'.$player->flag)}}" alt="{{ $player->team }}"> {{ $player->team }}</h4>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>{{ $player->name }}</li>
                        <li>Année : {{ $player->birthdate }}</li>
                        <li>Rôle : {{ $player->role }}</li>
                        <li>Buts : {{ $player->goal }}</li>
                    </ul>
                    <a href="{{ route('matches', 'incoming', $player->team_id) }}" role="button" class="btn btn-primary btn-green">Pariez !</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
