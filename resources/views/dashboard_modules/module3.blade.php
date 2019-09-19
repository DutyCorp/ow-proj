<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module3.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #A2DED0; padding: 5px;">Invoice Figure {{ date('Y') }} (License, Service, Maintenance)</b></div>
</div>
<div class="form-group row" style="font-size: 14px;">
	<div class="col-md-3 col-sm-3 col-xs-3 centered" title="$ {{ number_format($AmountInvoice, 2, '.', ',') }}"><b class="purple-color" style="font-size: 28px;" id="numAmountInvoice">{{ number_format($AmountInvoice, 0, '.', '') }}</b><br>Amount Invoice</div>
	<div class="col-md-3 col-sm-3 col-xs-3 centered" title="$ {{ number_format($AmountExpected, 2, '.', ',') }}"><b class="blue-color" style="font-size: 28px;" id="numAmountInvoiceExpected">{{ number_format($AmountExpected, 0, '.', '') }}</b><br>Amount Expected</div>
	<div class="col-md-3 col-sm-3 col-xs-3 centered"><b class="purple-color" style="font-size: 28px;">{{ $Achievement }}</b><br>Achievement</div>
	<div class="col-md-3 col-sm-3 col-xs-3 centered" title="$ {{ number_format($OpenInvoiceCurrentYear, 2, '.', ',') }}/{{ number_format($OpenInvoiceAll, 2, '.', ',') }}"><b class="blue-color" style="font-size: 28px;" id="numOpenInvoice">{{ number_format($OpenInvoiceCurrentYear, 0, '.', '') }}/{{ number_format($OpenInvoiceAll, 0, '.', '') }}</b><br>Open Invoice {{ date('Y') }}/Total</div>
</div>
<div style="overflow-y: scroll; height: 280px; font-size: 12px;">
	<div class="col-md-12" style="margin-left: -15px;"><b style="background-color: #A2DED0; padding: 3px; font-size: 14px; ">Invoice Against Budget</b></div>
	@foreach ($ListChartData as $ChartData)
		@if ($ChartData->Achievement != null && $ChartData->Target != null)
			<div class="col-md-3 col-sm-3 col-xs-6 centered"><input type="hidden" id="cr{{ $ChartData->BusinessAreaName }}" class="chartrevenue" value="{{ $ChartData->Achievement }}+n{{ $ChartData->Target }}"><canvas id="chartRevenue{{ $ChartData->BusinessAreaName }}" class="crisp"></canvas>{{ $ChartData->BusinessAreaName }}</div>
		@endif
	@endforeach
</div>