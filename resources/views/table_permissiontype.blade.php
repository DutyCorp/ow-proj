<script src="{{asset('js/TablePermissionType.js')}}"></script>
<table id="PTTable" class="table table-bordered">
	<thead style="background-color:#ECECEC;font-weight:bold" style="font-size:12px">
		<tr>
			<th style="text-align:center">Permission Type ID</th>
			<th style="text-align:center">Permission Type Name</th>
			<th style="text-align:center">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListPermissionType as $PT)
			<tr>
				<td style="padding:3px 10px 1px">{{ $PT->PermissionID }}</td>
				<td style="padding:3px 10px 1px">{{ $PT->PermissionType }}</td>
				<td style="padding:0px" align="center">
					<button style="padding:0px 1px" value="{{ $PT->PermissionID }}" class="ChooseEditPT btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{ $PT->PermissionID }}" class="ChooseDeletePT btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>	
				</td>
			</tr>
		@endforeach
	</tbody>
</table>