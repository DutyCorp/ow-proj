<div class="container" style="margin-top: 27%; background-color: #FFFFFF; width: 100%; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.15);">
	<br><div class="col-md-10 col-md-offset-1">
		<div class="form-group row">
			@foreach($ListRegionData as $RegionData)
				@if ($RegionData->RegionName != "Asia" && $RegionData->Address != "")
					<div class="col-md-2 col-sm-4 col-xs-6" style="font-size: 12px;"><b>{{ $RegionData->RegionName }}</b><br>{{ $RegionData->Address }}<br>{{ $RegionData->Phone_Office }}</div>
				@endif
			@endforeach
		</div>
		<img src="{{ session()->get('OWLogo') }}" style="width: 200px;">
		<h6><b>&copy; 2017-{{ date('Y') }} OpenWay Asia Pte Ltd</b></h6>
		<h6>Version <b>1.1</b></h6>
	</div>
</div>

