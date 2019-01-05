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
    <h3>Modifier une équipe</h3>
    <form enctype="multipart/form-data" method="POST" action="{{action('Admin\TeamsController@update', $team->id)}}">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <div class="form-group">
            <label>Nom</label>
            <input type="text" class="form-control" name="name" value="{{ $team->name }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Pays</label>
            <input type="text" class="form-control" name="country" placeholder="ex:France">
        </div>
        <div>
            <img alt={{$team->flag}} src="{{asset('images/'.$team->flag)}}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">inserer le drapeau</label>
            <input type="file" class="form-control-file" name='flag'>
        </div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>

@endsection