@extends('admin.layouts.menu')
@section('content')

    <div class="card">
        <div class="card-header" style="background-color: #0f4c75;color: white;text-align: right">
            <a href="{{url('/projets/liste')}}">
                <button class="btn btn-outline-light" style="width: 120px">Détails</button>
            </a>
        </div>

        <div class="card-body">
            <div class="container">
                <div class="response alert alert-success mt-2" style="display: none;"></div>
                <div id='calendar'></div>
            </div>
        </div>

    </div>

@endsection


