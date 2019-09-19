<script src="{{asset('js/TablePermissionApproval.js')}}"></script>
<table id="TableAppPermission" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr style="font-size:12px">
			<td>Permission ID</td>
			<td>Employee Name</td>
			<td>Coordinator</td>
			<td>Date (yyyy-mm-dd)</td>
			<td>Permission Type</td>
			<td>Notes</td>
			<td>Status</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListPermissionApproval as $App)
			<tr style="font-size:12px">
				<td>{{ $App->TransactionPermissionID }}</td>
				<td>{{ $App->EmployeeID }}</td>
				<td>{{ $App->CoordinatorID }}</td>
				<td>{{ date('Y-m-d', strtotime($App->Date)) }}</td>
				<td>{{ $App->PermissionID }}</td>
				<td>{{ $App->Notes }}</td>
				<td>
					<select style="font-size:12px" id="selectApproval{{$App->TransactionPermissionID}}" class="form-control">
						<option value="Approved">
							Approved
						</option>
						<option value="Rejected">
							Rejected
						</option>
					</select>
				</td>
				@if ( $App->CoordinatorID == session()->get('EmployeeName'))
					<td>
						<button value="{{ $App->TransactionPermissionID }}" class="ChooseApprovePermission btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
					</td>
				@else
					<td>
						<button disabled value="{{ $App->TransactionPermissionID }}" class="ChooseApprovePermission btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
					</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>