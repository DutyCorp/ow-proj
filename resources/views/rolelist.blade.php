@foreach($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
	<script src="{{asset('js/rolelistcommands.js')}}"></script>
	<table id="tableRole" class="table table-bordered" style="font-size: 12px;">
		<thead>
			<tr>
				<td>Role ID</td>
				<td>Role Name</td>
				@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
				<td>Action</td>
				@endif
			</tr>
		</thead>
		<tbody>
			@foreach($roles as $role)
			<tr>
				<td>{{ $role->RoleID }}</td>
				<td>{{ $role->RoleName }}</td>
				@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
				<td>
					@if($rolemenu->Role_U == "1")
					<button class="btnEdit btn btn-success" value="{{ $role->RoleID }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					@endif
					@if($rolemenu->Role_D == "1")
					<button class="btnDelete btn btn-danger" value="{{ $role->RoleID }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
					@endif
				</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
@endforeach