@extends('layouts.default')

@section('content')

    <h3>
        Parier sur le Match
        <img class="rounded" src="{{asset('images/'.$match->flag_1)}}" alt="{{ $match->team_1 }}">
        {{ $match->team_1 }} VS {{ $match->team_2 }}
        <img src="{{asset('images/'.$match->flag_2)}}" class="rounded" alt="{{ $match->team_2 }}">
        prévu le {{ $match->date }} à {{ $match->time }}
    </h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('bets.store') }}">
        @csrf
        <input name="match_id" type="hidden" value="{{ $match->id }}">
        <input name="user_id" type="hidden" value="{{ $user_id }}">
        <div class="form-group">
            <label>Mise</label>
            <input type="text" class="form-control" name="mise">
        </div>
        <div class="form-group">
            <label>Parier sur</label>
            <select class="browser-default" name="cote_bets">
                <option value="{{ $match->cote_team_1 }}">{{ $match->team_1 }} - Cote {{ $match->cote_team_1 }}</option>
                <option value="{{ $match->cote_match_n }}">Match Nul - Cote {{ $match->cote_match_n }}</option>
                <option value="{{ $match->cote_team_2 }}">{{ $match->team_2 }} - Cote {{ $match->cote_team_2 }}</option>
            </select><br>
        </div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>

@endsection
