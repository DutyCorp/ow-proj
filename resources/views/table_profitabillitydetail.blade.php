@foreach($LastsUpdate as $LastUpdate)
<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="profitabillityTable"  class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td colspan="7" style="text-align:center"></td>
			<td colspan="4" style="text-align:center">Project Expenses</td>
			<td colspan="4" style="text-align:center">% Project Expenses and Against Budget</td>
			<td colspan="3" style="text-align:center">Mandays</td>
		</tr>
		<tr>
			<th>Region</th>
			<th>Project ID</th>
			<th>Contract Code</th>
			<th>Contract Name</th>
			<th>Contract Status</th>
			<th>Position Type</th>
			<th>Project_Value</th>
			<th>MD_Cost</th>
			<th>*)Travel_Cost</th>
			<th>Other_Cost</th>
			<th>Total</th>
			<th>%MD Cost</th>
			<th>*)%Travel Cost</th>
			<th>%Other Cost</th>
			<th>%Expense Against Budget</th>
			<th>Budget</th>
			<th>Posted</th>
			<th>%MDSpent</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListProfitabillity as $Profitabillity)
			<tr>
				<td>{{ $Profitabillity->RegionName }}</td>
				<td>{{ $Profitabillity->ProjectID }}</td>
				<td>{{ $Profitabillity->ContractID }}</td>
				<td>{{ $Profitabillity->ContractName }}</td>
				<td>{{ $Profitabillity->ContractStatus }}</td>
				<td>{{ $Profitabillity->PositionType }}</td>
				<td>USD {{ $Profitabillity->ProjectValue }}</td>
				<td>USD {{ $Profitabillity->MDCost }}</td>
				<td>USD {{ $Profitabillity->TravelCost }}</td>
				<td>USD {{ $Profitabillity->OtherCost }}</td>
				<td>USD {{ $Profitabillity->Total }}</td>
				@if( $Profitabillity->PercentageMDCost == null)
					<td>0.0</td>
				@else 
					<td>{{ $Profitabillity->PercentageMDCost }}</td>	
				@endif	
				@if( $Profitabillity->PercentageTravelCost == null)
					<td>0.0</td>
				@else 
					<td>{{ number_format((float)$Profitabillity->PercentageTravelCost, 1, '.', ',') }}</td>
				@endif
				@if( $Profitabillity->PercentageOtherCost == null)
					<td>0.0</td>
				@else 
					<td>{{ $Profitabillity->PercentageOtherCost }}</td>
				@endif
				@if( $Profitabillity->PercentageExpenseAgainstBudget == null)
					<td>0.0</td>
				@else 
					@if($Profitabillity->PercentageExpenseAgainstBudget > 100)
						<td style="background-color:#f44256; color:#fff">{{ number_format((float)$Profitabillity->PercentageExpenseAgainstBudget, 1, '.', ',') }}</td>
					@else
						<td>{{ number_format((float)$Profitabillity->PercentageExpenseAgainstBudget, 1, '.', ',') }}</td>
					@endif
				@endif

				
				<td>{{ number_format((float)$Profitabillity->Budget, 1, '.', ',') }}</td>
				<td>{{ number_format((float)$Profitabillity->MDPosted, 1, '.', ',') }}</td>
				@if( $Profitabillity->PercentageMD == null)
					<td>0.0</td>
				@else 
					@if( $Profitabillity->PercentageMD >= 100)
						<td style="background-color:#f44256; color:#fff">{{ number_format((float)$Profitabillity->PercentageMD, 1, '.', ',') }}</td>
					@elseif ( $Profitabillity->PercentageMD >= 75)
						<td style="background-color:#f1f441">{{ number_format((float)$Profitabillity->PercentageMD, 1, '.', ',') }}</td>
					@else
						<td>{{ number_format((float)$Profitabillity->PercentageMD, 1, '.', ',') }}</td>
					@endif	
				@endif	
			</tr>
		@endforeach
	</tbody>
</table>