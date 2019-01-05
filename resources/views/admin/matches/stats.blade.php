@extends('layouts.admin')

@section('content')

    <h3>Statistiques du match</h3>

    <form method="POST" action="{{ route('admin.matches.update_stats', $match->id) }}">
        @csrf
        <input name="_method" type="hidden" value="PUT">
        <div class="form-group">
            <label>Meteo</label>
            <input type="text" class="form-control" name="weather" value="{{ $match->weather }}">
        </div>
        <div class="form-group">
            <label>Cartons</label>
            <textarea class="form-control" name="faults">{{ $match->faults }}</textarea>
        </div>
        <div class="form-group">
            <label>Actions principales</label>
            <textarea class="form-control" name="actions">{{ $match->actions }}</textarea>
        </div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </form>

@endsection