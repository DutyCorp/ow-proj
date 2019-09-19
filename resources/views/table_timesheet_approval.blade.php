<table id="TimesheetApprovalTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align:center">Project ID</th>
			<th style="text-align:center">Project Name</th>
			<th style="text-align:center">Phase Name</th>
			<th style="text-align:center">Date</th>
			<th style="text-align:center">MDQty</th>
			<th style="text-align:center">Activity</th>
			<th style="text-align:center">Memo</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListTimesheet as $Timesheet)
			<tr>
				<td style="padding:3px 10px 1px">{{ $Timesheet->ProjectID }}</td>
				<td style="padding:3px 10px 1px">{{ $Timesheet->ProjectName }}</td>
				<td style="padding:3px 10px 1px">{{ $Timesheet->PhaseName }}</td>
				<td style="padding:3px 10px 1px">{{ $Timesheet->Date }}</td>
				<td style="padding:3px 10px 1px">{{ $Timesheet->MDQty }}</td>
				<td style="padding:3px 10px 1px">{{ $Timesheet->Activity }}</td>
				<td style="padding:3px 10px 1px">{{ $Timesheet->Memo }}</td>
			</tr>
		@endforeach
	</tbody>
</table>