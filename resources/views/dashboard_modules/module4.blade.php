<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module4.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #C5EFF7; padding: 5px;">Top 5 Closed Deals (License and Services)</b></div>
</div>
<div style="font-size: 12px;">
	<div class="col-md-12">
		<?php $i = 1; ?>
		@foreach ($ListChartData as $ChartData)
		<input type="hidden" id="cd{{ $i }}" value="{{ $ChartData->ProjectName }}+-{{ $ChartData->ClosedDeals }}">
		<?php $i++; ?>
		@endforeach
		<canvas id="chartClosedDeals" height="380px" class="crisp"></canvas>
	</div>
</div>