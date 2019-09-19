@foreach($LastsUpdate as $LastUpdate)
	<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="attendanceListTable" class="stripe row-border order-column table table-bordered" width="100%" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align:center">Employee ID</th>
			<th style="text-align:center">Name</th>
			<th style="text-align:center">Region</th>
			<th style="text-align:center">Date (yyyy-mm-dd)</th>
			<th style="text-align:center">Time In</th>
			<th style="text-align:center">Time Out</th>
			<th style="text-align:center">Fullfillment</th>
			<th style="text-align:center">Status</th>
			<th style="text-align:center">Permission</th>
			<th style="text-align:center">Notes</th>
		</tr>
	</thead>
	<tbody>
		@foreach($AttendanceList as $List)
			@if ($List->AttendanceStatus == "Late")
				<tr bgcolor="#f44256">
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->EmployeeID }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->EmployeeName }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->RegionName }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ date('Y-m-d, D', strtotime($List->Date)) }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->Time_In }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->Time_Out }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->Fullfillment }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->AttendanceStatus }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->PermissionType }}</font></td>
					<td style="padding:3px 10px 1px"><font color="#fff">{{ $List->Notes }}</font></td>
				</tr>
			@elseif ($List->AttendanceStatus== "Permit")
				<tr bgcolor="#f1f441">
					<td style="padding:3px 10px 1px">{{ $List->EmployeeID }}</td>
					<td style="padding:3px 10px 1px">{{ $List->EmployeeName }}</td>
					<td style="padding:3px 10px 1px">{{ $List->RegionName }}</td>
					<td style="padding:3px 10px 1px">{{ date('Y-m-d, D', strtotime($List->Date)) }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Time_In }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Time_Out }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Fullfillment }}</td>
					<td style="padding:3px 10px 1px">{{ $List->AttendanceStatus }}</td>
					<td style="padding:3px 10px 1px">{{ $List->PermissionType }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Notes }}</td>
				</tr>
			@else
				<tr>
					<td style="padding:3px 10px 1px">{{ $List->EmployeeID }}</td>
					<td style="padding:3px 10px 1px">{{ $List->EmployeeName }}</td>
					<td style="padding:3px 10px 1px">{{ $List->RegionName }}</td>
					<td style="padding:3px 10px 1px">{{ date('Y-m-d, D', strtotime($List->Date)) }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Time_In }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Time_Out }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Fullfillment }}</td>
					<td style="padding:3px 10px 1px">{{ $List->AttendanceStatus }}</td>
					<td style="padding:3px 10px 1px">{{ $List->PermissionType }}</td>
					<td style="padding:3px 10px 1px">{{ $List->Notes }}</td>
				</tr>
			@endif	
		@endforeach
	</tbody>
</table>