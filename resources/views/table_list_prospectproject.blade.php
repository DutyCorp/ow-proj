<script src="{{asset('js/TableListProspectProject.js')}}"></script>
<table id="PP_List_Table"  class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align: center;">Project Code</th>
			<th style="text-align: center;">Project Name</th>
			<th style="text-align: center;">Project Region</th>
			<th style="text-align: center;">Business Area</th>
			<th style="text-align: center;">MD Plan</th>
			<th style="text-align: center;">Opportunity ( % )</th>
			<th style="text-align: center;">Weighted MD</th>
			<th style="text-align: center;">Start Project</th>
			<th style="text-align: center;">Period</th>
			<th style="text-align: center;">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListProspectProject as $ProspectProject)
			<tr>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->ProspectProjectID }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->ProjectName }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->RegionID }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->BusinessArea }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->MDPlan }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->Opportunity }}</td>
				<td style="padding:3px 10px 1px">{{ ($ProspectProject->Opportunity  *  $ProspectProject->MDPlan ) / 100 }}  </td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->StartProject }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->Year }}</td>
				<td style="padding:3px 10px 1px">
					<button style="padding:0px 1px" value="{{ $ProspectProject->ProspectProjectID }},{{ $ProspectProject->Year }}" class="ChooseEditPP btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{ $ProspectProject->ProspectProjectID }},{{ $ProspectProject->Year }}" class="ChooseDeletePP btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>