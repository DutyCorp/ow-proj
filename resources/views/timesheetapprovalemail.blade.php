<!DOCTYPE html>
<html>
<head>
	<title>Timesheet Approval</title>
	<style type="text/css">
		body {
		    font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
		    font-size: 10pt;
		}
		.smallfont {
			font-size: 8pt;
		}
		.centered {
			text-align: center;
		}
		th, td {
		    padding: 1px;
		    text-align: left;
		}
		table, th, td {
		    border: 1px solid black;
		    border-collapse: collapse;
		}
	</style>
</head>
<body>
	<div class="container">
		<p>Dear {{ $PMName }}, </p>
		<p>This is a summary of daily tasks of {{ $EmployeeName }} during {{ $Month }}.</p>
		<table>
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<th>&nbsp;Project Type&nbsp;</th>
					<th>&nbsp;Mandays&nbsp;</th>
				</tr>
			</thead>
			<?php $TimesheetTotal = 0; ?>
			<tbody>
				@foreach($ListTimesheetSummary as $TimesheetSummary)
				<tr>
					<td class="smallfont">&nbsp;{{  $TimesheetSummary->ProjectType }}&nbsp;</td>
					<td class="smallfont centered">&nbsp;{{ number_format($TimesheetSummary->TotalQty, 2, '.', ',') }}&nbsp;</td>
					<?php 
						$TimesheetTotal += $TimesheetSummary->TotalQty;
					?>
				</tr>
				@endforeach
				<tr>
					<td class="smallfont">&nbsp;Total&nbsp;</td>
					<td class="smallfont centered">&nbsp;{{ number_format($TimesheetTotal, 2, '.', ',') }}&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<p>And here are detail of tasks done by {{ $EmployeeName }} for your review. Any wrong time allocation need to be communicated and followed by correction action due until end of current month.<br></p>
		<p>Note : <br>Red Font 	: Changed Record (if any)<br>Green Font 	: Additional Record (if any)</p>
		<table>
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<th>&nbsp;Project ID&nbsp;</th>
					<th>&nbsp;Project Name&nbsp;</th>
					<th>&nbsp;Phase Name&nbsp;</th>
					<th>&nbsp;Date&nbsp;</th>
					<th>&nbsp;Quantity (Md)&nbsp;</th>
					<th>&nbsp;Activity&nbsp;</th>
					<th>&nbsp;Memo&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				@foreach($ListTimesheetData as $TimesheetData)
					@if ($TimesheetData->isAdditional == "1")
					<tr>
						<td class="smallfont"><font color="#26A65B">&nbsp;{{ $TimesheetData->ProjectID }}&nbsp;</font></td>
						<td class="smallfont"><font color="#26A65B">&nbsp;{{ $TimesheetData->ProjectName }}&nbsp;</font></td>
						<td class="smallfont"><font color="#26A65B">&nbsp;{{ $TimesheetData->PhaseName }}&nbsp;</font></td>
						<td class="smallfont"><font color="#26A65B">&nbsp;{{ date('d/m/Y', strtotime($TimesheetData->Date)) }}&nbsp;</font></td>
						<td class="smallfont centered"><font color="#26A65B">&nbsp;{{ number_format($TimesheetData->MDQty, 2, '.', ',') }}&nbsp;</font></td>
						<td class="smallfont"><font color="#26A65B">&nbsp;{{ $TimesheetData->Activity }}&nbsp;</font></td>
						<td class="smallfont"><font color="#26A65B">&nbsp;{{ $TimesheetData->Memo }}&nbsp;</font></td>
					</tr>
					@elseif ($TimesheetData->isChanged == "1")
					<tr>
						<td class="smallfont"><font color="#CF000F">&nbsp;{{ $TimesheetData->ProjectID }}&nbsp;</font></td>
						<td class="smallfont"><font color="#CF000F">&nbsp;{{ $TimesheetData->ProjectName }}&nbsp;</font></td>
						<td class="smallfont"><font color="#CF000F">&nbsp;{{ $TimesheetData->PhaseName }}&nbsp;</font></td>
						<td class="smallfont"><font color="#CF000F">&nbsp;{{ date('d/m/Y', strtotime($TimesheetData->Date)) }}&nbsp;</font></td>
						<td class="smallfont centered"><font color="#CF000F">&nbsp;{{ number_format($TimesheetData->MDQty, 2, '.', ',') }}&nbsp;</font></td>
						<td class="smallfont"><font color="#CF000F">&nbsp;{{ $TimesheetData->Activity }}&nbsp;</font></td>
						<td class="smallfont"><font color="#CF000F">&nbsp;{{ $TimesheetData->Memo }}&nbsp;</font></td>
					</tr>
					@else
					<tr>
						<td class="smallfont">&nbsp;{{ $TimesheetData->ProjectID }}&nbsp;</td>
						<td class="smallfont">&nbsp;{{ $TimesheetData->ProjectName }}&nbsp;</td>
						<td class="smallfont">&nbsp;{{ $TimesheetData->PhaseName }}&nbsp;</td>
						<td class="smallfont">&nbsp;{{ date('d/m/Y', strtotime($TimesheetData->Date)) }}&nbsp;</td>
						<td class="smallfont centered">&nbsp;{{ number_format($TimesheetData->MDQty, 2, '.', ',') }}&nbsp;</td>
						<td class="smallfont">&nbsp;{{ $TimesheetData->Activity }}&nbsp;</td>
						<td class="smallfont">&nbsp;{{ $TimesheetData->Memo }}&nbsp;</td>
					</tr>
					@endif
				@endforeach
			</tbody>
		</table>
		<p>By end of month you certify that all the postings from your subordinates are true and correct to the best of your knowledge. Thank you for your cooperation to manage the work of the team and taking the necessary actions in Maringo.</p>
		<p>Regards, </p>
		<p>Project Management Team</p>
		<br><br><br>
		<?php 
			$t = microtime(true);
			$micro = sprintf("%06d",($t - floor($t)) * 1000000);
			$d = new DateTime( date('d-m-Y H:i:s.'.$micro, $t) );
		?>
		<p class="smallfont">P.S. Please do not reply this email.</p>
		<p class="smallfont">This message was automatically generated on {{ $d->format("d-m-Y H:i:s.u") }} GMT+7</p>
	</div>
</body>
</html>