<script src="{{asset('js/TableDepartment.js')}}"></script>
<table id="DepartmentTable" class="table table-bordered">
	<thead style="background-color:#ECECEC;font-weight:font-size:12px">
		<tr>
			<td style="text-align:center">Department ID</td>
			<td style="text-align:center">Department Name</td>
			<td style="text-align:center">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListDepartment as $Department)
			<tr>
				<td style="padding:3px 10px 1px">{{$Department->DepartmentID}}</td>
				<td style="padding:3px 10px 1px">{{$Department->DepartmentName}}</td>
				<td align="center" style="padding:0px">
					<button style="padding:0px 1px" value="{{$Department->DepartmentID}}" class="ChooseEditDepartment btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{$Department->DepartmentID}}" class="ChooseDeleteDepartment btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>