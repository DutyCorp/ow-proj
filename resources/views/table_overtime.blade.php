@foreach($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
		<script src="{{asset('js/TableOvertime.js')}}"></script>
		<table id="overtimeTable" class="table table-bordered" style="font-size:12px">
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<th style="text-align:center">Overtime ID</th>
					<th style="text-align:center">Employee</th>
					<th style="text-align:center">Project Manager</th>
					<th style="text-align:center">Date ( yyyy-mm-dd )</th>
					<th style="text-align:center">Type</th>
					<th style="text-align:center">Notes</th>
					<th style="text-align:center">Status</th>
					<th style="text-align:center">Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($ListOvertime as $Overtime)
					<tr>
						<td style="padding:3px 10px 1px">{{ $Overtime->OverTimeID }}</td>
						<td style="padding:3px 10px 1px">{{ $Overtime->EmployeeName }}</td>
						<td style="padding:3px 10px 1px">{{ $Overtime->CoordinatorName }}</td>
						<td style="padding:3px 10px 1px">{{ date('Y-m-d, D', strtotime($Overtime->Date)) }}</td>
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
						@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
						<td style="text-align:center; padding:0px">
							@if($rolemenu->Role_U == "1")
								@if ($Overtime->ApprovalID == 1)
									<button style="padding:0px 1px" value="{{ $Overtime->OverTimeID }}" class="ChooseEditOvertime btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
								@endif
							@endif
							@if($rolemenu->Role_D == "1")
								@if ($Overtime->ApprovalID == 1)
									<button style="padding:0px 3px" value="{{ $Overtime->OverTimeID }}" class="ChooseDeleteOvertime btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
								@endif
							@endif
						</td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@endforeach