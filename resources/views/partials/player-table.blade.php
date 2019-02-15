<table class="table table-bordered primary">
	<thead>
		<tr>
			<th>Name</th>
			<th>Winner</th>
		</tr>
	</thead>
	<tbody>
		@foreach($results as $key => $user) {!! Form::open(['url' => 'players/{{$user->id}}', 'method' => 'patch']) !!}
		<input name="_method" type="hidden" value="PATCH">
		<tr>
			<td>
				{{$user->name}}
			</td>
			<td>
				{{$user->winner}} @if($user->status === 0) {!!Form::select('winner', [$user->id => $user->name, $current_player->id => $current_player->name],
				null, ['placeholder' => 'Select...', 'class' => 'form-control custom-select']) !!} @endif
			</td>
			<td class="text-center">
				@if($user->status === 0) {!! Form::hidden('current_player', $current_player->id ) !!} {!! Form::hidden('a', $user->id ) !!}
				{!! Form::hidden('b', $current_player->id ) !!} {!! Form::submit('Save',['class'=> 'btn btn-primary']) !!} @else

				<span class="fa fa-check"></span> @endif
			</td>
		</tr>
		{!! Form::close() !!} @endforeach
	</tbody>
</table>