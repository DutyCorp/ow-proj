@foreach($LastsUpdate as $LastUpdate)
	<p id="SalesContractLastUpdate">Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($LastUpdate->LatestUpdate)) }}</b></p>
@endforeach
<table id="salesContractTable" class="table table-bordered" style="font-size: 12px">
	<thead style="background-color:#ECECEC;font-weight:bold;text-align:center" >
		<tr>
			<td style="text-align:center">Business Area</td>
			<td style="text-align:center">Project</td>
			<td style="text-align:center">Project Name</td>
			<td style="text-align:center">Project Status</td>
			<td style="text-align:center">Contract</td>
			<td style="text-align:center">Contract Name</td>
			<td style="text-align:center">Contract Date (yyyy-mm-dd)</td>
			<td style="text-align:center">Contract Status</td>
			<td style="text-align:center">License (USD)</td>
			<td style="text-align:center">Services (USD)</td>
			<td style="text-align:center">Maintenance (USD)</td>
			<td style="text-align:center">Travel Expenses (USD)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListSalesContract as $SalesContract)
			<tr>
				<td style="padding:3px 10px 1px">{{ $SalesContract->BusinessArea }}</td>
				<td style="padding:3px 10px 1px">{{ $SalesContract->ProjectID }}</td>
				<td style="padding:3px 10px 1px">{{ $SalesContract->ProjectName }}</td>
				<td style="padding:3px 10px 1px">{{ $SalesContract->ProjectStatus }}</td>
				<td style="padding:3px 10px 1px">{{ $SalesContract->ContractID }}</td>
				<td style="padding:3px 10px 1px">{{ $SalesContract->ContractName }}</td>
				<td style="padding:3px 10px 1px">{{ date('Y-m-d', strtotime($SalesContract->ContractDate)) }}</td>
				<td style="padding:3px 10px 1px">{{ $SalesContract->ContractStatus }}</td>
				<td style="padding:3px 10px 1px">{{ number_format((float)$SalesContract->Licenses, 2, '.', ',') }}</td>
				<td style="padding:3px 10px 1px">{{ number_format((float)$SalesContract->Service, 2, '.', ',') }}</td>
				<td style="padding:3px 10px 1px">{{ number_format((float)$SalesContract->Maintenance, 2, '.', ',') }}</td>
				<td style="padding:3px 10px 1px">{{ number_format((float)$SalesContract->TravelExpense, 2, '.', ',') }}</td>
			</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
            <th style="padding:3px 10px 1px; background-color:#ffff80; text-align:center" colspan="8">Sub Total</th>
            <th style="padding:3px 10px 1px; background-color:#ffff80"></th>
            <th style="padding:3px 10px 1px; background-color:#ffff80"></th>
            <th style="padding:3px 10px 1px; background-color:#ffff80"></th>
            <th style="padding:3px 10px 1px; background-color:#ffff80"></th>
        </tr>
    </tfoot>
</table>