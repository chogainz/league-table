@extends('layouts.app') 
@section('content')

<div class="container-full-height d-flex align-items-center justify-content-center">
    <div class="row d-flex justify-content-center">
        <div class="card">
            <div class="card-header">
                <h5>New Player</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('games/') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="control-label">Name</label>
                        <div>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>                            @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span> @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection