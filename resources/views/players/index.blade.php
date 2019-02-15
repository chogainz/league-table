@extends('layouts.app') 
@section('content')
<div class="row d-flex justify-content-center">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>
                League Players
            </h5>

            <a class="btn btn-success" href="{{ route('players.create')}}">Add player</a>
        </div>
        <div class="card-body">
    @include('partials.players-table')
        </div>
    </div>
</div>
@endsection