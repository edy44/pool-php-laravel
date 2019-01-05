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
            <th scope="col">Validation</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <form method="POST" action="{{ route('matches.store') }}" >
                @csrf
                <td><input type="date" class="form-control" name="date" value="2000-00-00"></td>
                <td><input type="time" class="form-control" name="time" value="18:00"></td>
                <td>
                    <select class="browser-default" name="team_1">
                        <?php foreach ($teams as $team): ?>
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                            <?php endforeach; ?>
                    </select><br>
                </td>
                <td>
                    <select class="browser-default" name="team_2">
                        <?php foreach ($teams as $team): ?>
                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                        <?php endforeach; ?>
                    </select><br>
                </td>
                <td><input type="text" class="form-control" name="emplacement" value="" placeholder="Stade Louis 2"></td>
                <td><input type="text" class="form-control" name="cote_team_1" value="0.00"></td>
                <td><input type="text" class="form-control" name="cote_match_n" value="0.00"></td>
                <td><input type="text" class="form-control" name="cote_team_2" value="0.00"></td>
                <td><button type="submit" class="btn btn-primary">Valider</button></td>
            </form>
        </tr>
        </tbody>
    </table>
@endsection
