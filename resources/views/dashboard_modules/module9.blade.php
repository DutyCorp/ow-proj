<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module9.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #C5EFF7; padding: 5px;">Closed Projects on {{ date('F') }}</b></div>
</div>
<div class="form-group row" style="font-size: 12px;">
	<div class="col-md-12"><div class="rectangle blue-rectangle"></div> Target MD <div class="rectangle purple-rectangle"></div> Actual MD</div>
</div>
<div style="overflow-y: scroll; height: 340px; width: 100%;">
	<?php $i = 1; ?>
	@foreach ($ListChartData as $ChartData)
	<?php if (is_float($ChartData->TargetMD)){
		$TargetMD = number_format($ChartData->TargetMD, 2, '.', '');
	} else {
		$TargetMD = $ChartData->TargetMD;
	}

	if (is_float($ChartData->ActualMD)){
		$ActualMD = number_format($ChartData->ActualMD, 2, '.', '');
	} else {
		$ActualMD = $ChartData->ActualMD;
	} ?>
	<input type="hidden" id="clp{{ $i }}" class="closedprojects" value="{{ $TargetMD }}+-{{ $ActualMD }}+-{{ $ChartData->ProjectName }}">
	<?php $i++; ?>
	@endforeach
	<div class="col-md-12"><canvas id="chartClosedProjects" class="crisp" width="1100px"></canvas></div>
</div>