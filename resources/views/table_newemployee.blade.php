<script src="{{asset('js/TableNewEmployee.js')}}"></script>
<table id="NE_Table" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<th style="text-align: center;">Action</th>
		<th style="text-align: center;">Employee ID</th>
		<th style="text-align: center;">Employee Name</th>
		<th style="text-align: center;">Region</th>
		<th style="text-align: center;">Start Working Date</th>
		<th style="text-align: center;">Period</th>
	</thead>
	<tbody>
		@foreach($ListNewEmployee as $NE)
			<tr>
				<td style="padding:0px" align="center">
					@if($NE->Contributing == 1)
						<input value="{{ $NE->NewEmployeeID }}" class="ContributeNE" type="checkbox" checked>
                    @else
                    	<input value="{{ $NE->NewEmployeeID }}" class="ContributeNE" type="checkbox">
                    @endif
                </td>
				<td style="padding:3px 10px 1px">{{ $NE->NewEmployeeID }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->EmployeeName }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->RegionID }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->StartWorkingDate }}</td>
				<td style="padding:3px 10px 1px">{{ $NE->Year }}</td>
			</tr>
		@endforeach
	</tbody>
</table>