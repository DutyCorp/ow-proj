@foreach($LastsUpdate as $LastUpdate)
	<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="claimReportTable"  class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th>Travel Expenses Name</th>
			<th style="background-color: #F9BF3B;">Travel Expenses by Travel Expenses Name<br>(USD)</th>
		</tr>
	</thead>
	<tbody>
		
	</tbody>
</table>