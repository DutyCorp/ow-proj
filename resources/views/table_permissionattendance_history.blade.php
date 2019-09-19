@foreach($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
		<table id="PermissionAttendanceHistoryTable" class="stripe row-border order-column table table-bordered" style="font-size:12px">
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<th style="text-align:center">Permission ID</th>
					<th style="text-align:center">Name</th>
					<th style="text-align:center">Coordinator</th>
					<th style="text-align:center">Date (yyyy-mm-dd)</th>
					<th style="text-align:center">Type</th>
					<th style="text-align:center">Notes</th>
					<th style="text-align:center">Status</th>
					<th style="text-align:center">Last Update</th>
				</tr>
			</thead>
			<tbody>
				@foreach($ListPermissionAttendance as $PermissionAttendance)
					<tr>
						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->TransactionPermissionID }}</td>
						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->EmployeeName }}</td>
						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->CoordinatorID }}</td>
						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->Date }}</td>
						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->PermissionType }}</td>
						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->Notes }}</td>

						@if ( $PermissionAttendance->ApprovalID == "Rejected" )
							<td style="background-color:#e54040; padding:3px 10px 1px"><font color="#fff">{{ $PermissionAttendance->ApprovalID }}</font></td>
						@elseif ( $PermissionAttendance->ApprovalID == "Approved" )
							<td style="background-color:#1E824C; padding:3px 10px 1px"><font color="#fff">{{ $PermissionAttendance->ApprovalID }}</font></td>
						@else
							<td style="padding:3px 10px 1px">{{ $PermissionAttendance->ApprovalID }}</td>
						@endif

						<td style="padding:3px 10px 1px">{{ $PermissionAttendance->Tr_User_U }} , {{ $PermissionAttendance->Tr_Date_U }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@endforeach