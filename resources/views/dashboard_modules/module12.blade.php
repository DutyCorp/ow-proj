<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module12.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #FDE3A7; padding: 5px;">Personal Report</b></div>
</div>
<div style="overflow-y: scroll; height: 380px;">
	<div class="col-md-12"><img src="{{ session()->get('Photo') }}" id="individualPicture" class="birthdayboy" style="display: block; margin-left: auto; margin-right: auto;"></div>
	<div class="col-md-12" style="text-align: center;">{{ session()->get('EmployeeName') }}</div>
	@foreach($ListChartAttendanceData as $ChartAttendanceData)
	<input type="hidden" id="individualAttendanceData" value="{{ $ChartAttendanceData->OnTime }}+n{{ $ChartAttendanceData->Late }}+n{{ $ChartAttendanceData->Permit }}">
	@endforeach
	@foreach($ListChartOccupationData as $ChartOccupationData)
		@if ($ChartOccupationData->EmployeeName != NULL)
			<input type="hidden" id="individualOccupationData" value="{{ $ChartOccupationData->Chargeability }}+n{{ $ChartOccupationData->Utilization }}+n{{ $Month }}+n{{ $ChartOccupationData->EmployeeName }}">
		@endif
	@endforeach
	<div class="col-md-6"><canvas id="individualAttendanceChart" height="220px"><div id="chartjs-tooltip"></div></canvas></div>
	<div class="col-md-6"><canvas id="individualOccupationChart" height="220px"><div id="chartjs-tooltip"></div></canvas></div>	
	<p class="centered" id="individualError"></p>
</div>
<script type="text/javascript">
	$("#individualPicture").on('error', function () {
		$('#individualPicture').attr('src', "/a/{{ Crypt::encrypt('Face_Blue_128.png') }}");
	});
</script>