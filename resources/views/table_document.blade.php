<script src="{{asset('js/TableDocumentRegistration.js')}}"></script>

<table id="DocumentRegistrationTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align:center">Doc. Number</th>
			<th style="text-align:center">Region</th>
			<th style="text-align:center">Type</th>
			<th style="text-align:center">Date (yyyy-mm-dd)</th>
			<th style="text-align:center">Description</th>
			<th style="text-align:center">Owner</th>
			<th style="text-align:center">Attention to</th>
			<th style="text-align:center">Approver</th>
			<th style="text-align:center">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListDocument as $Document)
			<tr>
				<td style="padding:3px 10px 1px">{{ $Document->DocumentNumber }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->RegionName }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->DocumentTypeName }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->DocumentDate }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->Description }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->Owner }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->Destination }}</td>
				<td style="padding:3px 10px 1px">{{ $Document->DocumentApprover }}</td>
				<td style="padding:0px">
					<button style="padding:0px 1px" value="{{ $Document->DocumentNumber }}" class="ChooseEditDocument btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{ $Document->DocumentNumber }}" class="ChooseDeleteDocument btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>	
				</td>
			</tr>
		@endforeach
	</tbody>
</table>