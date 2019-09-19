<script src="{{asset('js/FTETable.js')}}"></script>
<table id="FTETable" class="table table-bordered no-wrap" style="width: 1805px;">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td>Employee ID</td>
			<td>Employee Name</td>
			<td>Region</td>
			<td>Year</td>
			<td>FTE1</td>
			<td>FTE2</td>
			<td>FTE3</td>
			<td>FTE4</td>
			<td>FTE5</td>
			<td>FTE6</td>
			<td>FTE7</td>
			<td>FTE8</td>
			<td>FTE9</td>
			<td>FTE10</td>
			<td>FTE11</td>
			<td>FTE12</td>
			<td>FTE Q1</td>
			<td>FTE Q2</td>
			<td>FTE Q3</td>
			<td>FTE Q4</td>
			<td>FTE</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListFTE as $FTE)
		<tr>
			<td class="EmployeeID">{{ $FTE->EmployeeID }}</td>
			<td>{{ $FTE->EmployeeName }}</td>
			<td>{{ $FTE->RegionName }}</td>
			<td class="Year">{{ $FTE->Year }}</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE1 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE2 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE3 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE4 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE5 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE6 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE7 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE8 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE9 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE10 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE11 }}"> %</td>
			<td><input type="text" class="FTE form-control" style="width: 75%;" value="{{ $FTE->FTE12 }}"> %</td>
			<td>{{ $FTE->FTEQ1 }}%</td>
			<td>{{ $FTE->FTEQ2 }}%</td>
			<td>{{ $FTE->FTEQ3 }}%</td>
			<td>{{ $FTE->FTEQ4 }}%</td>
			<td>{{ $FTE->FTE }}%</td>
		</tr>
		@endforeach
	</tbody>
</table>