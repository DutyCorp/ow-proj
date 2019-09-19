@foreach($LastsUpdate as $LastUpdate)
	<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="claimReportTable" class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th>Travel Expenses Name</th>
			@for ($i = 0; $i < $CountTable; $i++)
				<th>{{ $ProjectNames[$i]->ProjectName }}<br>(USD)</th>
			@endfor
			<th style="background-color: #F9BF3B;">Travel Expenses Total by Travel Expenses Name<br>(USD)</th>
		</tr>
		<?php $TETotal = []; ?>
	</thead>
	<tbody>
		@foreach($ListClaimReport as $ClaimReport)
		<tr>
			<?php $TEProject = 0; ?>
			<td>{{ $ClaimReport->TEName }}</td>
			@for ($i = 0; $i < $CountTable; $i++)
				<?php $PN = (string)$ProjectNames[$i]->ProjectName; ?>
				@if (isset($ClaimReport->{$PN}))
					@if ($ClaimReport->{$PN} == '0')
						<td></td>
					@else 
						<td>{{ number_format($ClaimReport->{$PN}, 2, '.', ',') }}</td>
					@endif
					
					<?php 
						if (isset($TETotal[$i])){
							$TETemp = 0;
							$TETemp = $ClaimReport->{$PN}; 
							$TETotal[$i] += $TETemp;
						} else {
							$TETotal[$i] = 0;
							$TETotal[$i] = $ClaimReport->{$PN};
						}
						$TEProject += $ClaimReport->{$PN};
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
			<th style="background-color: #F9BF3B;">Travel Expense Total<br>(USD)</th>
			<?php $TETotalProject = 0; ?>
			@for ($j = 0; $j < $i; $j++)
				@if (isset ($TETotal[$j]))
					@if ($TETotal[$j] == '0')
						<th style="background-color: #F9BF3B;"></th>
					@else
						<th style="background-color: #F9BF3B;">{{ number_format($TETotal[$j], 2, '.', ',') }}</th>
					@endif
					<?php $TETotalProject += $TETotal[$j]; ?>
				@endif
			@endfor
			@if ($TETotalProject == '0')
				<td style="background-color: #F9BF3B;"></td>
			@else 
				<td style="background-color: #F9BF3B;"><b>{{ number_format($TETotalProject, 2, '.', ',') }}</b></td>
			@endif
		</tr>
	</tfoot>
</table>