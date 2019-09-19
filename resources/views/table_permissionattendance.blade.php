@foreach ($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
		<script src="{{asset('js/TablePermission.js')}}"></script>
		<table id="PermitTable" class="table table-bordered" style="font-size:12px">
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<td style="text-align:center">Permission ID</td>
					<td style="text-align:center">Name</td>
					<td style="text-align:center">Coordinator</td>
					<td style="text-align:center">Date( yyyy-mm-dd Day )</td>
					<td style="text-align:center">Type</td>
					<td style="text-align:center">Notes</td>
					<td style="text-align:center">Status</td>
					@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
						<td style="text-align:center">Action</td>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach($ListPermissionAttendance as $List)
				<tr>
					<td style="padding:3px 10px 1px">{{$List->TransactionPermissionID}}</td>
					<td style="padding:3px 10px 1px">{{$List->EmployeeName}}</td>
					<td style="padding:3px 10px 1px">{{$List->CoordinatorID}}</td>
					<td style="padding:3px 10px 1px">{{date('Y-m-d, D', strtotime($List->Date))}}</td>
					<td style="padding:3px 10px 1px">{{$List->PermissionType}}</td>
					<td width="auto" style="padding:3px 10px 1px">{{$List->Notes}}</td>	
					@if ( $List->ApprovalID == "Rejected" )
					<td style="background-color:#e54040; padding:3px 10px 1px"><font color="#fff">{{ $List->ApprovalID }}</font></td>
					@elseif ( $List->ApprovalID == "Approved" )
					<td style="background-color:#1E824C; padding:3px 10px 1px"><font color="#fff">{{ $List->ApprovalID }}</font></td>
					@else
					<td style="padding:3px 10px 1px">{{ $List->ApprovalID }}</td>
					@endif
					@if($rolemenu->Role_U == "1" || $rolemenu->Role_D == "1")
					<td style="padding:0px; text-align:center">
						@if ($rolemenu->Role_U == "1")
							@if ($List->ApprovalID == "Pending")
								<button style="padding:0px 1px" value="{{$List->TransactionPermissionID}}" class="ChooseEdit btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
							@endif
						@endif
						@if ($rolemenu->Role_D == "1")
							@if ($List->ApprovalID == "Pending")
								<button style="padding:0px 3px" value="{{$List->TransactionPermissionID}}" class="ChooseDelete btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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