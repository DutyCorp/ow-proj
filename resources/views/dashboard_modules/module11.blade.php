<script type="text/javascript" src="{{ URL::to('/js/welcome_modules/module10.js') }}"></script>
<div class="form-group row">
	<div class="col-md-12"><b style="background-color: #FDE3A7; padding: 5px;">Birthday</b></div>
</div>
<?php $defaultprofilepicture = Crypt::encrypt('Face_Blue_128.png'); ?>
<div style="overflow-y: scroll; height: 380px;">
	@foreach ($ListChartData as $ChartData)
		@if ($ChartData->Birthday == date('d F Y'))
			<div class="col-md-12 col-sm-12 col-xs-12 birthdaybox birthdaytoday">
				@if ($ChartData->Photo != null)
				<div class="col-md-3 col-sm-3 col-xs-4"><br><img src="/f/{{ Crypt::encrypt($ChartData->Photo) }}" class="birthdayboy"></div>
				@else
				<div class="col-md-3 col-sm-3 col-xs-4"><img src="/a/{{ $defaultprofilepicture }}" class="birthdayboy"></div>
				@endif
				<div class="col-md-9 col-sm-9 col-xs-8" style="font-size: 12px;">{{ $ChartData->EmployeeName }}<br>{{ $ChartData->Birthday }}</div>
			</div>
		@else 
			<div class="col-md-12 col-sm-12 col-xs-12 birthdaybox">
				@if ($ChartData->Photo != null)
				<div class="col-md-3 col-sm-3 col-xs-4"><br><img src="/f/{{ Crypt::encrypt($ChartData->Photo) }}" class="birthdayboy"></div>
				@else
				<div class="col-md-3 col-sm-3 col-xs-4"><img src="/a/{{ $defaultprofilepicture }}" class="birthdayboy"></div>
				@endif
				<div class="col-md-9 col-sm-9 col-xs-8" style="font-size: 12px;">{{ $ChartData->EmployeeName }}<br>{{ $ChartData->Birthday }}</div>
			</div>
		@endif
	@endforeach
</div>