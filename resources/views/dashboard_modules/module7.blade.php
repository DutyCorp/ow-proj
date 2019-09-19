<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module7.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #DCC6E0; padding: 5px;">Occupation Rate YTD as of {{ date('F Y') }}</b></div>
</div>
<div class="form-group row" style="font-size: 12px;">
	<div class="col-md-12"><div class="rectangle purple-rectangle"></div> Chargeability <div class="rectangle red-rectangle"></div> Utilization</div>
</div>
<div style="overflow-y: scroll; height: 350px; font-size: 12px;">
	@foreach($ListChartData as $ChartData)
		<div class="col-md-3 col-sm-4 col-xs-6 centered"><input type="hidden" id="sp{{ $ChartData->RegionName }}" class="staffperformance" value="{{ $ChartData->Chargeable }}+-{{ $ChartData->Utilization }}"><div><canvas id="chartStaffPerformance{{ $ChartData->RegionName }}" height="330px" class="crisp"></canvas></div>{{ $ChartData->RegionName }}</div>
	@endforeach
</div>