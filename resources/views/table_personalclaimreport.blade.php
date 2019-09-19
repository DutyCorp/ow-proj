<table id="personalClaimReportTable"  class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold" style="font-size:12px">
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
			<td>{{ $ClaimReport->TEName }}</td>
			<td>{{ number_format($ClaimReport->Total, 2, '.', ',') }}</td>
		</tr>
		<?php $TETotal += $ClaimReport->Total ?>
		@endforeach
	</tbody>
	<tfoot>
		<tr style="background-color: #F9BF3B;">
			<th colspan="2" style="background-color: #F9BF3B;">Travel Expense Total<br>(USD)</th>
			<th style="background-color: #F9BF3B;"><b>{{ number_format($TETotal, 2, '.', ',') }}</b></th>
		</tr>
	</tfoot>
</table>