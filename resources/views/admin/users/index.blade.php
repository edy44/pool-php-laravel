@extends('layouts.admin')

@section('content')

    <h3>Liste des Utilisateurs</h3>

    <a href="{{ url('admin/users/create') }}" role="button" class="btn btn-primary" aria-disabled="true">Nouvel Utilisateur</a>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Solde</th>
            <th scope="col">Droits</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>
                    @if(!$user->balance)
                        -
                    @else
                        {{ $user->balance }} €
                    @endif
                </td>
                <td>
                    @if($user->admin == 'admin')
                        Administrateur
                    @else
                        Utilisateur
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" role="button" class="btn btn-primary">Modifier</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"
                                onclick="return confirm('Voulez-vous vraiment confirmer la suppression ?')">
                            Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection
