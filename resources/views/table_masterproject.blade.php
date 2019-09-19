<script src="{{asset('js/TableMasterProject.js')}}"></script>
<table id="masterProjectTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td style="text-align: center;">Project Code</td>
			<td style="text-align: center;">Project Name</td>
			<td style="text-align: center;">Project Type</td>
			<td style="text-align: center;">Region</td>
			<td style="text-align: center;">Business Area</td>
			<td style="text-align: center;">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListProject as $Project)
			<tr>
				<td style="padding:3px 10px 1px">{{ $Project->ProjectID }}</td>
				<td style="padding:3px 10px 1px">{{ $Project->ProjectName }}</td>
				<td style="padding:3px 10px 1px">{{ $Project->ProjectType }}</td>
				<td style="padding:3px 10px 1px">{{ $Project->RegionName }}</td>
				<td style="padding:3px 10px 1px">{{ $Project->BusinessAreaName }}</td>
				<td style="padding:0px; text-align:center">
					<button style="padding:0px 1px" value="{{ $Project->ProjectID }}" class="ChooseEditMasterProject btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{ $Project->ProjectID }}" class="ChooseDeleteMasterProject btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>	
				</td>
			</tr>
		@endforeach
	</tbody>
</table>