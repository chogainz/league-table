@extends('layouts.app') 
@section('content')
<div class="d-flex justify-content-center">
    <div class="row d-flex">

        <div class="card">
            <div class="card-header">
                <b>{{$current_player->name}}</b> | VS
            </div>
            <div class="card-body">
    @include('partials.player-table')
            </div>
        </div>
    </div>

</div>
@endsection