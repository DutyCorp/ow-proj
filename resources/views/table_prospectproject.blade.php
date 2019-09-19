<script src="{{asset('js/TableResourceAllocation.js')}}"></script>
<table id="PP_Table"  class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align: center;">Action</th>
			<th style="text-align: center;">Project Code</th>
			<th style="text-align: center;">Project Name</th>
			<th style="text-align: center;">Project Region</th>
			<th style="text-align: center;">Business Area</th>
			<th style="text-align: center;">MD Plan</th>
			<th style="text-align: center;">Opportunity ( % )</th>
			<th style="text-align: center;">Weighted MD</th>
			<th style="text-align: center;">Start Project</th>
			<th style="text-align: center;">Period</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListProspectProject as $ProspectProject)
			<tr>
				<td style="padding:0px" align="center">
					@if($ProspectProject->ContributingYear != NULL && $ProspectProject->ContributingRegion != NULL)
						<input value="{{ $ProspectProject->ProspectProjectID }},{{ $ProspectProject->ProjectYear }}" class="ContributeCB" type="checkbox" checked>
	                @else
                    	<input value="{{ $ProspectProject->ProspectProjectID }},{{ $ProspectProject->ProjectYear }}" class="ContributeCB" type="checkbox">
                    @endif
                </td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->ProspectProjectID }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->ProjectName }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->RegionID }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->BusinessArea }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->MDPlan }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->Opportunity }}</td>
				<td style="padding:3px 10px 1px">{{ ( $ProspectProject->Opportunity  *  $ProspectProject->MDPlan ) / 100 }}  </td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->StartProject }}</td>
				<td style="padding:3px 10px 1px">{{ $ProspectProject->ProjectYear }}</td>
			</tr>
		@endforeach
	</tbody>
</table>