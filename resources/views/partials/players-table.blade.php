<table class="table table-bordered players-table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($results as $key => $result)
		<tr>
			<td class="align-middle">
				{{$result->name}}
			</td>
			<td class="d-flex">
				<button class="btn btn-primary" onclick="window.location.href = '{{ route('players.show', $result->user_id)}}';">update results</button>
			</td>
		</tr>
		@endforeach 
		@foreach($users_not_played as $key => $result)
		<tr>
			<td class="align-middle">
				{{$result->name}}
			</td>
			<td class="d-flex justify-content-center">
				<button class="btn btn-primary" onclick="window.location.href = '{{ route('players.show', $result->id)}}';">update results</button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>