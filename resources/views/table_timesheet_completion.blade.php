<table id="TimesheetCompletionTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align:center">Region</th>
			<th style="text-align:center">EmployeeID</th>
			<th style="text-align:center">Name</th>
			<th style="text-align:center">Total</th>
			<th style="text-align:center">Target Hours</th>
			<th style="text-align:center">% Completion</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListTimesheet as $Timesheet)
			@if ($Timesheet->Completion > 100)
				<tr>
					<td style="padding:3px 10px 1px">{{ $Timesheet->RegionName }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->EmployeeID }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->EmployeeName }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->Hours }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->TWH }}</td>
					<td style="background-color: #f1f441; padding:3px 10px 1px">{{ $Timesheet->Completion }}</td>
				</tr>
			@elseif ($Timesheet->Completion < 100)
				<tr>
					<td style="padding:3px 10px 1px">{{ $Timesheet->RegionName }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->EmployeeID }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->EmployeeName }}</td>
					<td style="padding:3px 10px 1px" style="padding:3px 10px 1px">{{ $Timesheet->Hours }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->TWH }}</td>
					@if($Timesheet->Completion == 0 || $Timesheet->Completion == NULL )
						<td style="background-color: #f44256; padding:3px 10px 1px"><font color="#fff">0 %</font></td>
					@else
						<td style="background-color: #f44256; padding:3px 10px 1px"><font color="#fff">{{ $Timesheet->Completion }}</font></td>
					@endif
				</tr>
			@else
				<tr>
					<td style="padding:3px 10px 1px">{{ $Timesheet->RegionName }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->EmployeeID }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->EmployeeName }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->Hours }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->TWH }}</td>
					<td style="padding:3px 10px 1px">{{ $Timesheet->Completion }}</td>
				</tr>
			@endif
		@endforeach
	</tbody>
</table>