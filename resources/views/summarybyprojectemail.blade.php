<!DOCTYPE html>
<html>
<head>
	<title>Summary By Project</title>
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
		<p>Dear Project Leaders,</p>
		<p>Here are summary view by project during {{ $CurrentMonth }} for your review. Any wrong time allocation need to be communicated and followed by correction action due until end of month.</p>
		<table>
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<th>&nbsp;Project Type&nbsp;</th>
					<th>&nbsp;Mandays&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$TimesheetTotal = 0;
				?>
				@foreach($ListTimesheetSummary as $TimesheetSummary)
				<tr>
					<td class="smallfont">&nbsp;{{ $TimesheetSummary->ProjectType }}&nbsp;</td>
					<td class="smallfont centered">&nbsp;{{ number_format($TimesheetSummary->Mandays, 2, '.', ',') }}&nbsp;</td>
					<?php 
						$TimesheetTotal += $TimesheetSummary->Mandays;
					?>
				</tr>
				@endforeach
				<tr>
					<td class="smallfont">&nbsp;Total&nbsp;</td>
					<td class="smallfont centered">&nbsp;{{ number_format($TimesheetTotal, 2, '.', ',') }}&nbsp;</td>
				</tr>
			</tbody>
		</table><br>
		<table>
			<thead style="background-color:#ECECEC;font-weight:bold">
				<tr>
					<th rowspan="2" class="centered">&nbsp;Project ID&nbsp;</th>
					<th rowspan="2" class="centered">&nbsp;Project Name&nbsp;</th>
					<th rowspan="2" class="centered">&nbsp;MDBudget&nbsp;</th>
					<th rowspan="2" class="centered">&nbsp;MDLeft&nbsp;</th>
					<th colspan="2" class="centered">&nbsp;MDSpent&nbsp;</th>
				</tr>
				<tr>
					<th class="centered">&nbsp;Current Month&nbsp;</th>
					<th class="centered">&nbsp;Total&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$MDBudget = 0;
					$MDSpent = 0;
					$MDLeft = 0;
					$CurrentMonth = 0;
				 ?>
				@foreach($ListProjectTimesheetData as $ProjectTimesheetData)
				<tr>
					<td class="smallfont">&nbsp;{{ $ProjectTimesheetData->ProjectID }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ $ProjectTimesheetData->ProjectName }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($ProjectTimesheetData->MDBudget, 2, '.', ',') }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($ProjectTimesheetData->MDLeft, 2, '.', ',') }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($ProjectTimesheetData->CurrentMonth, 2, '.', ',') }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($ProjectTimesheetData->Total, 2, '.', ',') }}&nbsp;</td>
					<?php 
						$MDBudget += $ProjectTimesheetData->MDBudget;
						$MDSpent += $ProjectTimesheetData->Total;
						$MDLeft += $ProjectTimesheetData->MDLeft;
						$CurrentMonth += $ProjectTimesheetData->CurrentMonth;
					?>
				</tr>
				@endforeach
				<tr>
					<td colspan="2" class="smallfont">&nbsp;Total&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($MDBudget, 2, '.', ',') }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($MDLeft, 2, '.', ',') }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($CurrentMonth, 2, '.', ',') }}&nbsp;</td>
					<td class="smallfont">&nbsp;{{ number_format($MDSpent, 2, '.', ',') }}&nbsp;</td>
				</tr>
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
		<p class="smallfont">This message was automatically generated on {{ $d->format("d-m-Y H:i:s.u") }} GMT+7</p>
	</div>
</body>
</html>