<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module6.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #F1A9A0; padding: 5px;">Next Project Milestone (3 Months)</b></div>
</div>
<table id="tableMilestone" class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th>Project Name</th>
			<th>Date</th>
			<th>Milestone</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($ListChartData as $ChartData)
		<tr>
			<td>{{ $ChartData->ProjectName }}</td>
			<td>{{ $ChartData->Date }}</td>
			<td>{{ $ChartData->Milestone }}</td>
		</tr>
		@endforeach
	</tbody>
</table>