<table class="table table-bordered">
	<thead>
		<tr>
			<th class="text-center">Position</th>
			<th >Name</th>
			<th class="text-center">Played</th>
			<th class="text-center">Won</th>
			<th class="text-center">Lost</th>
			<th class="text-center">Points</th>
		</tr>
	</thead>
	<tbody>
		@foreach($results as $key => $result)
		<tr>
			<td class="text-center"> {{$result->position}} </td>
			<td> {{$result->name}} </td>
			<td class="text-center"> {{$result->played}} </td>
			<td class="text-center"> {{$result->won}} </td>
			<td class="text-center"> {{$result->lost}} </td>
			<td class="text-center"> {{$result->points}} </td>
		</tr>
		@endforeach @foreach($users_not_played as $key => $result)
		<tr>
			<td class="text-center"> </td>
			<td> {{$result->name}} </td>
			<td class="text-center"> 0 </td>
			<td class="text-center"> 0 </td>
			<td class="text-center"> 0 </td>
			<td class="text-center"> 0 </td>
		</tr>
		@endforeach
	</tbody>
</table>