<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module11.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #FDE3A7; padding: 5px;">Attendance Report Region</b></div>
</div>
<div style="overflow-y: scroll; height: 380px;">
	<?php $i = 0; ?>
	@foreach($ListChartData as $ChartData)
		<input type="hidden" id="rg{{ $i }}" class="regionData" value="{{ $ChartData->RegionID }}+n{{ $ChartData->OnTime }}+n{{ $ChartData->Late }}+n{{ $ChartData->Permit }}">
		<?php $i++; ?>
	@endforeach
	<input type="hidden" id="dt" value="{{ $DateFrom }}+n{{ $DateTo }}">
	<p class="centered" id="regionError"></p>
	<canvas id="regionChart"><div id="chartjs-tooltip"></div></canvas>
</div>