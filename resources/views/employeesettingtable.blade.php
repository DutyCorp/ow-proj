<table id="roleAccessTable" class="table table-bordered">	
	<thead>
		<tr>
			<td>Menu</td>
			<td>Sub Menu</td>
			<td>Menu Child</td>
			<td>Show</td>
			<td>Insert</td>
			<td>Update</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
		@foreach($menus as $menu)	
		<tr id="{{ $menu->MenuChildID }}">
			<td>{{ $menu->MenuParentName }}</td>
			<td>{{ $menu->SubMenuName }}</td>
			<td>{{ $menu->MenuChildName }}</td>
			@foreach($roleaccesses as $roleaccess)
				@if ($roleaccess->MenuChildID == $menu->MenuChildID)
					@if ($roleaccess->Role_S == 1)
						<td><input type="checkbox" checked="true" disabled></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($roleaccess->Role_I == 1)
						<td><input type="checkbox" checked="true" disabled></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($roleaccess->Role_U == 1)
						<td><input type="checkbox" checked="true" disabled></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
					@if ($roleaccess->Role_D == 1)
						<td><input type="checkbox" checked="true" disabled></td>
					@else
						<td><input type="checkbox" disabled></td>
					@endif
				@endif
			@endforeach
			@if(json_decode($roleaccesses, true) == null)
				<td><input type="checkbox" disabled></td>
				<td><input type="checkbox" disabled></td>
				<td><input type="checkbox" disabled></td>
				<td><input type="checkbox" disabled></td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>