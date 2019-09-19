@foreach($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
		<script src="{{asset('js/TableOvertimeApproval.js')}}"></script>
		<table id="overtimeApprovalTable" class="table table-bordered" style="font-size:12px">
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr style="font-size:12px">
					<td>Overtime ID</td>
					<td>Employee</td>
					<td>Project Manager</td>
					<td>Date (yyyy-mm-dd)</td>
					<td>Type</td>
					<td>Notes</td>
					@if ($rolemenu->Role_U == "1")
					<td>Status</td>
					<td>Action</td>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach($ListOvertime as $Overtime)
					<tr style="font-size:12px">
						<td>{{ $Overtime->OverTimeID }}</td>
						<td>{{ $Overtime->EmployeeName }}</td>
						<td>{{ $Overtime->CoordinatorName }}</td>
						<td>{{ date('Y-m-d', strtotime($Overtime->Date)) }}</td>
						<td>{{ $Overtime->OverTimeTypeName }}</td>
						<td>{{ $Overtime->Notes }}</td>
						@if ($rolemenu->Role_U == "1")
							<td>
								<select style="font-size:12px" id="selectApproval{{$Overtime->OverTimeID}}" class="form-control">
									<option value="Approved">
										Approved
									</option>
									<option value="Rejected">
										Rejected
									</option>
									<option value="ApprovedHalf">
										Approved ( in Lieu 0.5 Md )
									</option>
									<option value="ApprovedOne">
										Approved ( in Lieu 1 Md )
									</option>
								</select>
							</td>
							@if ( $Overtime->CoordinatorName == session()->get('EmployeeName'))
								<td>
									<button value="{{ $Overtime->OverTimeID }}" class="ChooseApproveOvertime btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
								</td>
							@else
								<td>
									<button disabled value="{{ $Overtime->OverTimeID }}" class="ChooseApproveOvertime btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
								</td>
							@endif
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@endforeach