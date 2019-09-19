@foreach($LastsUpdate as $LastUpdate)
	<p>Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="projectProgressTable" class="table table-bordered" style="font-size: 12px">
	<thead style="background-color:#ECECEC;font-weight:bold;text-align:center" >
		<tr>
			<td style="text-align:center">Project Manager</td>
			<td style="text-align:center">Project ID</td>
			<td style="text-align:center">Contract ID</td>
			<td style="text-align:center">Contract Name</td>
			<td style="text-align:center">Position Type</td>
			<td style="text-align:center">MDBudget</td>
			<td style="text-align:center">MDPosted</td>
			<td style="text-align:center; background-color: #22A7F0">MDLeft</td>
			<td style="text-align:center">MDOutlook</td>
			<td style="text-align:center">100% Project Value (USD)</td>
			<td style="text-align:center">Invoiced (USD)</td>
			<td style="text-align:center; background-color: #22A7F0">MDSpent (%)</td>
			<td style="text-align:center; background-color: #22A7F0">Invoiced (%)</td>
			<td style="text-align:center">Closure Date (yyyy-mm-dd)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListProjectProgress as $ProjectProgress)
		<tr>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->ProjectManager }}</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->ProjectID }}</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->ContractID }}</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->ContractName }}</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->PositionType }}</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->MDPhaseBudget }} Md</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->MDPosted }} Md</td>
			@if ($ProjectProgress->MDLeft < 0)
				<td style="padding:3px 10px 1px; background-color: #ff4c4c"><font color="#fff"><b>{{ $ProjectProgress->MDLeft }} Md</b></font></td>
			@else 
				<td style="padding:3px 10px 1px">{{ $ProjectProgress->MDLeft }} Md</td>
			@endif
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->MDPositionBudget }} Md</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->PositionPrice }}</td>
			<td style="padding:3px 10px 1px">{{ $ProjectProgress->Invoiced }}</td>
			@if ($ProjectProgress->MDSpent >= 100)
				<td style="padding:3px 10px 1px; background-color: #ff4c4c"><font color="#fff"><b>{{ $ProjectProgress->MDSpent }}%</b></font></td>
			@elseif ($ProjectProgress->MDSpent >= 75)
				<td style="padding:3px 10px 1px; background-color: #F4D03F"><b>{{ $ProjectProgress->MDSpent }}%</b></td>
			@elseif ($ProjectProgress->MDSpent == NULL)
				<td style="padding:3px 10px 1px">0 %</td>
			@else 
				<td style="padding:3px 10px 1px">{{ $ProjectProgress->MDSpent }}%</td>
			@endif
			@if ($ProjectProgress->Invoice == NULL)
				<td style="padding:3px 10px 1px; background-color: #ff4c4c"><font color="#fff"><b>0 %</b></font></td>
			@elseif ($ProjectProgress->Invoice < 100)
				<td style="padding:3px 10px 1px; background-color: #ff4c4c"><font color="#fff"><b>{{ number_format($ProjectProgress->Invoice) }}%</b></font></td>
			@else
				<td style="padding:3px 10px 1px">{{ number_format($ProjectProgress->Invoice) }}%</td>
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