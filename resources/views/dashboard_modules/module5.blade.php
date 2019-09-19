<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module5.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #A2DED0; padding: 5px;">Critical Project</b></div>
</div>
<div class="form-group row" style="font-size: 12px;">
	<div class="col-md-9">Budget Absorption : <div class="circle2 red-circle"></div> >= 100% <div class="circle2 yellow-circle"></div> >= 75% <div class="circle2 green-circle"></div> < 75%</div>
	<div class="col-md-3" style="text-align: right;">Cost : MDPosted x USD{{ $MDCost }}</div>
</div>
<div style="overflow-y: scroll; height: 330px; font-size: 12px;">
	<div class="form-group row">
		<div class="col-md-3 col-sm-3 col-xs-3 centered"><b>Project Name</b></div>
		<div class="col-md-2 col-sm-2 col-xs-2 centered"><b>MDPosted</b></div>
		<div class="col-md-2 col-sm-2 col-xs-2 centered"><b>MDLeft</b></div>
		<div class="col-md-2 col-sm-2 col-xs-2 centered"><b>Cost</b></div>
		<div class="col-md-3 col-sm-3 col-xs-3 centered"><b>Cost Absorption</b></div>
	</div>
	@foreach ($ListChartData as $ChartData)
	<div class="form-group row">
		<div class="col-md-3 col-sm-3 col-xs-3">{{ $ChartData->ProjectName }}</div>
		@if ($ChartData->MDConsumption >= 100.00)
		<div class="col-md-2 col-sm-2 col-xs-2"><div class="circle red-circle" title="{{ $ChartData->MDConsumption }}"></div></div>
		@elseif ($ChartData->MDConsumption >= 75.00)
		<div class="col-md-2 col-sm-2 col-xs-2"><div class="circle yellow-circle" title="{{ $ChartData->MDConsumption }}"></div></div>
		@else 
		<div class="col-md-2 col-sm-2 col-xs-2"><div class="circle green-circle" title="{{ $ChartData->MDConsumption }}"></div></div>
		@endif
		<div class="col-md-2 col-sm-2 col-xs-2 centered">{{ $ChartData->MDLeft }}</div>
		@if ($ChartData->Cost >= 100.00)
		<div class="col-md-2 col-sm-2 col-xs-2"><div class="circle red-circle" title="{{ $ChartData->Cost }}"></div></div>
		@elseif ($ChartData->Cost >= 75.00)
		<div class="col-md-2 col-sm-2 col-xs-2"><div class="circle yellow-circle" title="{{ $ChartData->Cost }}"></div></div>
		@else 
		<div class="col-md-2 col-sm-2 col-xs-2"><div class="circle green-circle" title="{{ $ChartData->Cost }}"></div></div>
		@endif
		<div class="col-md-3 col-sm-3 col-xs-3 centered">{{ $ChartData->CostAbsorption }}</div>
	</div>
	@endforeach
</div>