<table id="overtimeHistoryTable" class="table table-bordered" style="font-size: 12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td style="text-align:center">Overtime ID</td>
			<td style="text-align:center">Employee</td>
			<td style="text-align:center">Project Manager</td>
			<td style="text-align:center">Date (yyyy-mm-dd)</td>
			<td style="text-align:center">Type</td>
			<td style="text-align:center">Notes</td>
			<td style="text-align:center">Status</td>
			<td style="text-align:center">Last Update</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListOvertime as $Overtime)
			<tr>
				<td style="padding:3px 10px 1px">{{ $Overtime->OverTimeID }}</td>
				<td style="padding:3px 10px 1px">{{ $Overtime->EmployeeName }}</td>
				<td style="padding:3px 10px 1px">{{ $Overtime->CoordinatorName }}</td>
				<td style="padding:3px 10px 1px">{{ date('Y-m-d', strtotime($Overtime->Date)) }}</td>
				<td style="padding:3px 10px 1px">{{ $Overtime->OverTimeTypeName }}</td>
				<td style="padding:3px 10px 1px">{{ $Overtime->Notes }}</td>
				@if ( $Overtime->ApprovalID == 3 )
					<td style="background-color:#e54040; padding:3px 10px 1px"><font color="#fff">{{ $Overtime->ApprovalName }}</font></td>
				@elseif ( $Overtime->ApprovalID == 2 )
					<td style="background-color:#1E824C; padding:3px 10px 1px"><font color="#fff">{{ $Overtime->ApprovalName }}</font></td>
				@elseif ( $Overtime->ApprovalID == 5 || $Overtime->ApprovalID == 6 )
					<td style="background-color:#FFEE58; padding:3px 10px 1px"><font color="#000000">{{ $Overtime->ApprovalName }}</font></td>
				@else
					<td style="padding:3px 10px 1px">{{ $Overtime->ApprovalName }}</td>
				@endif
				@if( $Overtime->Tr_User_U  != null)
					<td style="padding:3px 10px 1px">{{ $Overtime->Tr_User_U }} , {{ date('Y-m-d', strtotime($Overtime->Tr_Date_U)) }}</td>
				@else
					<td style="padding:3px 10px 1px">-</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>