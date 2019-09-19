@foreach($LastsUpdate as $LastUpdate)
<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="projectProgressTable" class="table table-bordered" style="font-size: 12px">
	<thead style="background-color:#ECECEC;font-weight:bold;text-align:center" >
		<tr>
			<td>Project Manager</td>
			<td>Project ID</td>
			<td>Contract ID</td>
			<td>Contract Name</td>
			<td>Position Type</td>
			<td>MDBudget</td>
			<td>MDPosted</td>
			<td style="background-color: #22A7F0">MDLeft</td>
			<td>MDOutlook</td>
			<td style="background-color: #22A7F0">MDSpent (%)</td>
			<td style="background-color: #22A7F0">Invoiced (%)</td>
			<td style="text-align:center">Closure Date (yyyy-mm-dd)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListProjectProgress as $ProjectProgress)
		<tr>
			<td>{{ $ProjectProgress->ProjectManager }}</td>
			<td>{{ $ProjectProgress->ProjectID }}</td>
			<td>{{ $ProjectProgress->ContractID }}</td>
			<td>{{ $ProjectProgress->ContractName }}</td>
			<td>{{ $ProjectProgress->PositionType }}</td>
			<td>{{ $ProjectProgress->MDPhaseBudget }} Md</td>
			<td>{{ $ProjectProgress->MDPosted }} Md</td>
			@if ($ProjectProgress->MDLeft < 0)
				<td style="background-color: #ff4c4c"><font color="#fff"><b>{{ $ProjectProgress->MDLeft }} Md</b></font></td>
			@else 
				<td>{{ $ProjectProgress->MDLeft }} Md</td>
			@endif
			<td>{{ $ProjectProgress->MDPositionBudget }} Md</td>
			@if ($ProjectProgress->MDSpent >= 100)
				<td style="background-color: #ff4c4c"><font color="#fff"><b>{{ $ProjectProgress->MDSpent }}%</b></font></td>
			@elseif ($ProjectProgress->MDSpent >= 75)
				<td style="background-color: #F4D03F"><b>{{ $ProjectProgress->MDSpent }}%</b></td>
			@elseif ($ProjectProgress->MDSpent == NULL)
				<td>0 %</td>
			@else 
				<td>{{ $ProjectProgress->MDSpent }}%</td>
			@endif
			@if ($ProjectProgress->Invoice == NULL)
				<td style="background-color: #ff4c4c"><font color="#fff"><b>0 %</b></font></td>
			@elseif ($ProjectProgress->Invoice < 100)
				<td style="background-color: #ff4c4c"><font color="#fff"><b>{{ number_format($ProjectProgress->Invoice) }}%</b></font></td>
			@else
				<td>{{ number_format($ProjectProgress->Invoice) }}%</td>
			@endif
			@if ($ProjectProgress->ClosureDate == '1970-01-01')
				<td style="padding:3px 10px 1px"></td>
			@else
				<td style="padding:3px 10px 1px">{{ $ProjectProgress->ClosureDate }}</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>