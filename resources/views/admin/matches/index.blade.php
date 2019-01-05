@extends('layouts.admin')

@section('content')
    <a href="{{ url('admin/matches/create') }}" role="button" class="btn btn-primary" aria-disabled="true">Nouveau Match</a>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Heure</th>
                <th scope="col">Match</th>
                <th scope="col">Emplacement</th>
                <th scope="col">Cote Équipe 1</th>
                <th scope="col">Cote Match nul</th>
                <th scope="col">Cote Équipe 2</th>
                <th scope="col">Vainqueur</th>
                <th scope="col">Score</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matches as $match)
                <tr>
                    <td>{{ $match->date }}</td>
                    <td>{{ $match->time }}</td>
                    <td>{{ $match->team_1 }} VS {{ $match->team_2 }}</td>
                    <td>{{ $match->emplacement }}</td>
                    <td>{{ $match->cote_team_1 }}</td>
                    <td>{{ $match->cote_match_n }}</td>
                    <td>{{ $match->cote_team_2 }}</td>
                    <td>{{ $match->winner }}</td>
                    <td>{{ $match->score }}</td>
               <td>
               @if(is_null($match->score))
                        <a href="{{ route('matches.edit', $match->id) }}" role="button" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('matches.destroy', $match->id) }}" method="POST">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button class="btn btn-danger" type="submit"
                                    onclick="return confirm('Voulez-vous vraiment confirmer la suppression ?')">
                                Supprimer</button>
                        </form>
                   @else
                       <a href="{{ route('admin.matches.stats', $match->id) }}" role="button" class="btn btn-info">Stats</a>
                       <span class="badge badge-success">Match et Paris terminés</span></h3>
                   @endif
               </td>
                </tr>
            @endforeach
        </tbody>

    </table>

@endsection
