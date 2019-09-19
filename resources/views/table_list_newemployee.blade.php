<script src="{{asset('js/TableListNewEmployee.js')}}"></script>
<table id="NE_List_Table" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<th style="text-align: center;">Employee ID</th>
		<th style="text-align: center;">Employee Name</th>
		<th style="text-align: center;">Region</th>
		<th style="text-align: center;">Start Working Date</th>
		<th style="text-align: center;">Period</th>
		<th style="text-align: center;">Action</th>
	</thead>
	<tbody>
		@foreach($ListNewEmployee as $NE)
			<tr>
				<td style="padding:3px 10px 1px">{{ $NE->NewEmployeeID }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->EmployeeName }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->RegionID }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->StartWorkingDate }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->Year }}</td>
				<td style="padding:3px 10px 1px">
					<button style="padding:0px 1px" value="{{ $NE->NewEmployeeID }}" class="ChooseEditNE btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{ $NE->NewEmployeeID }}" class="ChooseDeleteNE btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>