<script src="{{asset('js/TableRegion.js')}}"></script>
<table id="RegionTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td style="text-align:center">Region ID</td>
			<td style="text-align:center">Region Name</td>
			<td style="text-align:center">Phone Office</td>
			<td style="text-align:center">Address</td>
			<td style="text-align:center">Fax</td>
			<td style="text-align:center">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListRegion as $Region)
			<tr>
				<td style="padding:3px 10px 1px">{{ $Region->RegionID }}</td>
				<td style="padding:3px 10px 1px">{{ $Region->RegionName }}</td>
				<td style="padding:3px 10px 1px">{{ $Region->Phone_Office }}</td>
				<td style="padding:3px 10px 1px">{{ $Region->Address }}</td>
				<td style="padding:3px 10px 1px">{{ $Region->Fax }}</td>
				<td align="center" style="padding:0px">
					<button style="padding:0px 1px" value="{{ $Region->RegionID }}" class="ChooseEditRegion btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{ $Region->RegionID }}" class="ChooseDeleteRegion btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>