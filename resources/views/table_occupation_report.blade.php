<table  id="utilizationTable" class="table table-bordered" style="font-size: 12px">
		<thead style="background-color:#ECECEC;font-weight:bold;text-align:center">
			<tr>
				<td>Region</td>
				<td>Employee ID</td>
				<td>Employee Name</td>
				@if($TableType == "Detail")
					<td>Delivery (Md)</td>
					<td>Support (Md)</td>
					<td>Business Development (Md)</td>
					<td>Customer NB (Md)</td>
					<td>Internal (Md)</td>
					<td>Internal Improvement (Md)</td>
				@endif
				<td>FTE (Md)</td>
				<td>%Chargeability </td>
				<td>%Utilization </td>
			</tr>
		</thead>
		<tbody>
			@foreach($ListUtilization as $Utilization)
				<tr>
					<td style="padding:0px">{{ $Utilization->RegionName }}</td>
					<td style="padding:0px">{{ $Utilization->EmployeeID }}</td>
					<td style="padding:0px">{{ $Utilization->EmployeeName }}</td>
					@if($TableType == "Detail")
						<td style="padding:0px; text-align: center;">{{ $Utilization->Delivery }}</td>
						<td style="padding:0px; text-align: center;">{{ $Utilization->Support }}</td>
						<td style="padding:0px; text-align: center;">{{ $Utilization->BusinessDevelopment }}</td>
						<td style="padding:0px; text-align: center;">{{ $Utilization->CustomerNB }}</td>
						<td style="padding:0px; text-align: center;">{{ $Utilization->Internal }}</td>
						<td style="padding:0px; text-align: center;">{{ $Utilization->InternalImprovement }}</td>
					@endif
					<td style="padding:0px; text-align: center;">{{ $Utilization->FTE }}</td>
					<td style="padding:0px;">
						<div class="outer" style="width: 100%; margin: 0px; height: 20px; border-radius: 15px; position:relative; text-align: center;">
						    <span class="inner" style="background: linear-gradient(to right, rgba(255,0,0,1), rgba(255,0,0,0)); display:inline-block; position:absolute; left:0; width: {{ $Utilization->PercentageChargeable }}%; height: 20px;"></span>
						    @if ($Utilization->PercentageChargeable == NULL)
						    	<span class="gridSpan" style="display:inline-block; margin-top: 5px; color: black; position: relative;">0 %</span>
						    @else
						    	<span class="gridSpan" style="display:inline-block; margin-top: 5px; color: black; position: relative;">{{ $Utilization->PercentageChargeable }}%</span>
						    @endif
						</div>
		    		</td>
					<td style="padding:0px;">
						<div class="outer" style="width: 100%; margin: 0px; height: 20px; border-radius: 15px; position:relative; text-align: center;">
						    <span class="inner" style="background: linear-gradient(to right, rgba(255,0,0,1), rgba(255,0,0,0)); display:inline-block; position:absolute; left:0; width: {{ $Utilization->PercentageUtilization }}%; height: 20px;"></span>
						    @if ($Utilization->PercentageUtilization == NULL)
						    	<span class="gridSpan" style="display:inline-block; margin-top: 5px; color: black; position: relative;">0 %</span>
						    @else
						    	<span class="gridSpan" style="display:inline-block; margin-top: 5px; color: black; position: relative;">{{ $Utilization->PercentageUtilization }}%</span>
						    @endif
						</div>
					</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			@if($TableType == "Detail")
				<tr >
	                <th colspan="3" style="text-align:center">Sub Total</th>
	                <th style="text-align:center"></th>
	                <th style="text-align:center"></th>
	                <th style="text-align:center"></th>
	                <th style="text-align:center"></th>
	                <th style="text-align:center" ></th>
	                <th style="text-align:center"></th>
	                <th colspan="1" style="text-align:center"></th>
	                <th style="text-align:center"></th>
	                <th style="text-align:center"></th>
	            </tr>
	        @endif
	        @if($TableType == "Detail")
	        	@foreach($ListTotal as $Total)
	        		@if($Total->RegionName != 'Asia')
	        			<tr style="background-color:#ffff80" id="{{ $Total->RegionName }}" >
		                <th colspan="9" style="text-align:center">Total {{ $Total->RegionName }}</th>
		                <th id="FTEDetail{{ $Total->RegionName }}" style="text-align:center">{{ $Total->FTE }}</th>
		                <th id="ChargeDetail{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageChargeable }}%</th>
		                <th id="UtilizationDetail{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageUtilization }}%</th>
		           		</tr>
	        		@endif
	            @endforeach
	            @foreach($ListTotal as $Total)
	        		@if($Total->RegionName == 'Asia')
	        			<tr style="background-color:#80ff80" id="{{ $Total->RegionName }}" >
		                <th colspan="9" style="text-align:center">Total {{ $Total->RegionName }}</th>
		                <th id="FTEDetail{{ $Total->RegionName }}" style="text-align:center">{{ $Total->FTE }}</th>
		                <th id="ChargeDetail{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageChargeable }}%</th>
		                <th id="UtilizationDetail{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageUtilization }}%</th>
		           		</tr>
	        		@endif
	            @endforeach
            @else
	        	@foreach($ListTotal as $Total)
	        		@if($Total->RegionName != 'Asia')
	        			<tr style="background-color:#ffff80" id="{{ $Total->RegionName }}" >
		                <th colspan="3" style="text-align:center">Total {{ $Total->RegionName }}</th>
		                <th id="FTESummary{{ $Total->RegionName }}" style="text-align:center">{{ $Total->FTE }}</th>
		                <th id="ChargeSummary{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageChargeable }}%</th>
		                <th id="UtilizationSummary{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageUtilization }}%</th>
		           		</tr>
	        		@endif
	            @endforeach
	            @foreach($ListTotal as $Total)
	        		@if($Total->RegionName == 'Asia')
	        			<tr style="background-color:#80ff80" id="{{ $Total->RegionName }}" >
		                <th colspan="3" style="text-align:center">Total {{ $Total->RegionName }}</th>
		                <th id="FTESummary{{ $Total->RegionName }}" style="text-align:center">{{ $Total->FTE }}</th>
		                <th id="ChargeSummary{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageChargeable }}%</th>
		                <th id="UtilizationSummary{{ $Total->RegionName }}" style="text-align:center">{{ $Total->PercentageUtilization }}%</th>
		           		</tr>
	        		@endif
	            @endforeach
	        @endif
        </tfoot>
</table>
