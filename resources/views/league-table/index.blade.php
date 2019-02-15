@extends('layouts.app') 
@section('content')
<div class="row d-flex justify-content-center">
    <div class="card ">
        <div class="card-header">
            <h5>League Table</h5>
        </div>
        <div class="card-body">
    @include('partials.league-table')
        </div>
    </div>
</div>
@endsection