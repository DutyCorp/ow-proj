@foreach($LastsUpdate as $LastUpdate)
	<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="claimReportTable"  class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th>Travel Expenses Code</th>
			<th>Travel Expense Name</th>
			<th>Total<br>(USD)</th>
		</tr>
		<?php $TETotal = 0; ?>
	</thead>
	<tbody>
		@foreach($ListClaimReport as $ClaimReport)
		<tr>
			<td>{{ $ClaimReport->TECode }}</td>
			<td>{{ $ClaimReport->TEName }} </td>
			@if ($ClaimReport->Total == '0')
				<td></td>
			@else
				<td>{{ number_format($ClaimReport->Total, 2, '.', ',') }}</td>
			@endif
		</tr>
		<?php $TETotal += $ClaimReport->Total ?>
		@endforeach
	</tbody>
	<tfoot>
		<tr style="background-color: #F9BF3B;">
			<th colspan="2">Travel Expense Total<br>(USD)</th>
			@if ($TETotal == '0')
				<td style="background-color: #F9BF3B;"></td>
			@else
				<td style="background-color: #F9BF3B;"><b>{{ number_format($TETotal, 2, '.', ',') }}</b></td>
			@endif
		</tr>
	</tfoot>
</table>