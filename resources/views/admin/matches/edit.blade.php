@extends('layouts.admin')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Heure</th>
            <th scope="col">Equipe 1</th>
            <th scope="col">Equipe 2</th>
            <th scope="col">Emplacement</th>
            <th scope="col">Cote Équipe 1</th>
            <th scope="col">Cote Match nul</th>
            <th scope="col">Cote Équipe 2</th>
            <th scope="col">Vainqueur</th>
            <th scope="col">Score</th>
            <th scope="col">Validation</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <form method="POST" action="{{ route('matches.update', $match->id) }}" >
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <td><input type="date" class="form-control" name="date" value="{{ $match->date }}"></td>
                <td><input type="time" class="form-control" name="time" value="{{ $match->time }}"></td>
                <td>
                    <select class="browser-default" name="team_1">
                        @foreach($teams as $team)
                        <option value="{{ $team->id }}"
                        @if($team->id == $match->team_1)
                            selected
                                @endif
                        >{{ $team->name }}</option>
                        @endforeach
                    </select><br>
                </td>
                <td>
                    <select class="browser-default" name="team_2">
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}"
                                    @if($team->id == $match->team_2)
                                    selected
                                    @endif
                            >{{ $team->name }}</option>
                        @endforeach
                    </select><br>
                </td>
                <td><input type="text" class="form-control" name="emplacement" value="{{ $match->emplacement }}"></td>
                <td><input type="text" class="form-control" name="cote_team_1" value="{{ $match->cote_team_1 }}"></td>
                <td><input type="text" class="form-control" name="cote_match_n" value="{{ $match->cote_match_n }}"></td>
                <td><input type="text" class="form-control" name="cote_team_2" value="{{ $match->cote_team_2 }}"></td>
                <td>
                    <select class="browser-default" name="winner">
                            <option value="-1"></option>
                            <option value="0"
                                    @if($match->winner == 0)
                                        selected
                                    @endif
                            >Match Nul</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}"
                                        @if($match->winner == $team->id)
                                        selected
                                        @endif
                                >{{ $team->name }}</option>
                            @endforeach
                    </select><br>
                </td>
                <td><input type="text" class="form-control" name="score" value="{{ $match->score }}"></td>
                <td><button type="submit" class="btn btn-primary">Valider</button></td>
            </form>
        </tr>
        </tbody>
    </table>
@endsection
