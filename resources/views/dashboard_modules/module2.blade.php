<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module2.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #F1A9A0; padding: 5px;">Sales Trend Line (License and Services)</b></div>
</div>
<div class="form-group row">
	<div class="col-md-12">
		<?php $i = 1; ?>
		@foreach ($ListChartData as $ChartData)
		<input type="hidden" id="stl{{ $i }}" value="{{ $ChartData->Year }}+-{{ $ChartData->SalesTrendLine }}">
		<?php $i++; ?>
		@endforeach
		<canvas id="chartSalesTrendLine" height="380px" class="crisp"></canvas>
	</div>
</div>