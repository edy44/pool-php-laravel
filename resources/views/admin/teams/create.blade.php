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
    <h3>Créer une équipe</h3>
    <form method="post" action="{{url('admin/teams')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Nom</label>
            <input type="text" class="form-control" name="name" placeholder="ex:France">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Pays</label>
            <input type="text" class="form-control" name="country" placeholder="ex:France">
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">inserer le drapeau</label>
            <input type="file" class="form-control-file" name='flag'>
        </div>
        <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

@endsection