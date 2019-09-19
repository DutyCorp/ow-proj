<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module8.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #DCC6E0; padding: 5px;">New Projects on {{ date('Y') }}</b></div>
</div>
<table id="tableNewProject" class="stripe row-border order-column table table-bordered" style="font-size: 12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th>Contract Name</th>
			<th>Region</th>
			<th>Period</th>
			<th>MDBudget</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($ListChartData as $ChartData)
		<tr>
			<td>{{ $ChartData->ContractName }}</td>
			<td>{{ $ChartData->RegionID }}</td>
			<td>{{ $ChartData->Period }}</td>
			<td>{{ $ChartData->MDBudget }}</td>
		</tr>
		@endforeach
	</tbody>
</table>