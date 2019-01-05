@extends('layouts.admin')

@section('content')

<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Nom</th>
        <th scope="col">Drapeau</th>
        <th scope="col">Pays</th>
        <th scope="col">Actions</th>
        <th scope="col">Voir Joueurs</th>
    </tr>
    <div>
        <a href="{{ url('admin/teams/create') }}" role="button" class="btn btn-primary" aria-disabled="true">Nouvelle Equipe</a>
    </div>
    </thead>
    <tbody>
    @foreach($teams as $team)
    <tr>
        <td>{{$team->name}}</td>
        <td><img alt={{$team->flag}} class="rounded" src="{{asset('images/'.$team->flag)}}"></td>
        <td>{{$team->country}}</td>
        <td>
            <a href="{{ route('teams.edit', $team->id)}}" role="button" class="btn btn-primary">Modifier</a>
            <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <button class="btn btn-danger" type="submit"
                        onclick="return confirm('Voulez-vous vraiment confirmer la suppression ?')">
                    Supprimer</button>
            </form>
        </td>
        <td>
            <a href="{{ route('teams.show', $team->id) }}" role="button" class="btn btn-primary">Voir Equipe</a>
        </td>
    </tr>

    @endforeach
    </tbody>
</table>

@endsection
