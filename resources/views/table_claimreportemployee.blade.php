@foreach($LastsUpdate as $LastUpdate)
	<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="claimReportTable"  class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th>Employee Name</th>
			@for ($i = 0; $i < $CountTable; $i++)
				<th>{{ $TECodes[$i]->TEName }}<br>(USD)</th>
			@endfor
			<th style="background-color: #F9BF3B;">Travel Expenses by Employee<br>(USD)</th>
		</tr>
		<?php $TETotal = []; ?>
	</thead>
		@foreach($ListClaimReport as $ClaimReport)
		<tr>
			<?php $TEProject = 0; ?>
			<td>{{ $ClaimReport->EmployeeName }}</td>
			@for ($i = 0; $i < $CountTable; $i++)
				<?php $TE = (string)$TECodes[$i]->TEName; ?>
				@if (isset($ClaimReport->{$TE}))
					@if ($ClaimReport->{$TE} == '0')
						<td></td>
					@else 
						<td>{{ number_format($ClaimReport->{$TE}, 2, '.', ',') }}</td>
					@endif
					<?php 
						if (isset($TETotal[$i])){
							$TETemp = 0;
							$TETemp = $ClaimReport->{$TE}; 
							$TETotal[$i] += $TETemp;
						} else {
							$TETotal[$i] = 0;
							$TETotal[$i] = $ClaimReport->{$TE};
						}
						$TEProject += $ClaimReport->{$TE};
					?>
				@endif
			@endfor
			@if ($TEProject == '0')
				<td style="background-color: #F9BF3B;"></td>
			@else 
				<td style="background-color: #F9BF3B;"><b>{{ number_format($TEProject, 2, '.', ',') }}</b></td>
			@endif
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th colspan="1" style="background-color: #F9BF3B;">Travel Expense Total<br>(USD)</th>
			<?php $TETotalProject = 0; ?>
			@for ($j = 0; $j < $i; $j++)
				@if ($TETotal[$j] == '0')
					<td style="background-color: #F9BF3B;"></td>
				@else 
					<td style="background-color: #F9BF3B;"><b>{{ number_format($TETotal[$j], 2, '.', ',') }}</b></td>
				@endif
				<?php $TETotalProject += $TETotal[$j]; ?>
			@endfor
			@if ($TETotalProject == '0')
				<td style="background-color: #F9BF3B;"></td>
			@else 
				<td style="background-color: #F9BF3B;"><b>{{ number_format($TETotalProject, 2, '.', ',') }}</b></td>
			@endif
		</tr>
	</tfoot>
</table>