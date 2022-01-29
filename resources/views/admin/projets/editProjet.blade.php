@extends('admin.layouts.menu')
@section('content')
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header bg-dark" style="color: white">L'édite d'un projet</div>
            <div class="card-body">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                @endif
                <div class="col-md-6 offset-md-3">
                    <form method="post" action="{{url('/projets/'.$projet->id)}}" class="form">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label for="libelle">Libelle</label>
                            <input type="text" class="form-control" name="libelle" id="libelle" value="{{$projet->title}}">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" name="description" id="description" value="{{$projet->description}}" >
                        </div>

                        <div class="form-group">
                            <label for="localisation">Localisation</label>
                            <input type="text" class="form-control" name="localisation" id="localisation" value="{{$projet->localisation}}">
                        </div>

                        <button class="btn btn-outline-dark col-6 offset-3">Enregistrer</button>

                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
