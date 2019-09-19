<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module1.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #FDE3A7; padding: 5px;">Sales Figure {{ date('Y') }} (License and Services)</b></div>
</div>
<div class="form-group row" style="font-size: 14px;">
	<div class="col-md-3 col-sm-3 col-xs-3 centered" title="$ {{ number_format($AmountWon, 2, '.', ',') }}"><b class="blue-color" style="font-size: 28px;" id="numAmountWon">{{ number_format($AmountWon, 0, '.', '') }}</b><br>Amount Won</div>
	<div class="col-md-3 col-sm-3 col-xs-3 centered" title="$ {{ number_format($AmountExpected, 2, '.', ',') }}"><b class="purple-color" style="font-size: 28px;" id="numAmountExpected">{{ number_format($AmountExpected, 0, '.', '') }}</b><br>Amount Expected</div>
	<div class="col-md-3 col-sm-3 col-xs-3 centered"><b class="blue-color" style="font-size: 28px;">{{ $Achievement }}</b><br>Achieved</div>
	<div class="col-md-3 col-sm-3 col-xs-3 centered" title="$ {{ number_format($Pipeline, 2, '.', ',') }}"><b class="purple-color" style="font-size: 28px;" id="numPipeline">{{ number_format($Pipeline, 0, '.', '') }}</b><br>Pipeline</div>
</div>
<div style="overflow-y: scroll; height: 280px; font-size: 12px;">
	<div class="col-md-12" style="margin-left: -15px;"><b style="background-color: #FDE3A7; padding: 3px; font-size: 14px; ">Sales Against Target</b></div>
	@foreach ($ListChartData as $ChartData)
		@if ($ChartData->Achievement != null && $ChartData->Target != null)
		<div class="col-md-3 col-sm-3 col-xs-6 centered"><input type="hidden" id="ds{{ $ChartData->BusinessAreaName }}" class="chartsales" value="{{ $ChartData->Achievement }}+n{{ $ChartData->Target }}"><canvas id="chartSales{{ $ChartData->BusinessAreaName }}" class="crisp"></canvas>{{ $ChartData->BusinessAreaName }}</div>
		@endif
	@endforeach
</div>