@foreach($OparDate as $Opar)
	<p id="OpenInvoiceLastUpdate">Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($Opar->Tr_Date_I)) }}</b></p>
@endforeach
<table id="OpenInvoiceTable"  class="stripe row-border order-column table table-bordered" style="font-size: 11px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align:center">Project Code</th>
			<th style="text-align:center">Project Region</th>
			<th style="text-align:center">Contract Code</th>
			<th style="text-align:center">Contract Name</th>
			<th style="text-align:center">Accounting Description</th>
			<th style="text-align:center">Invoice Planned Date (yyyy-mm-dd)</th>
			<th style="text-align:center">Project Value (USD)</th>
			<th style="text-align:center">Pct</th>
			<th style="text-align:center">License (USD)</th>
			<th style="text-align:center">Service (USD)</th>
			<th style="text-align:center">Maintenance (USD)</th>
		</tr>
	</thead>
	<tbody>
		@foreach($ListOpenInvoice as $OpenInvoice)
		<tr>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->PCode }}</td>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->RegionID }}</td>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->CCode }}</td>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->CName }}</td>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->AccountingDescription }}</td>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->InvoicePlannedDate }}</td>
			<td style="padding:3px 10px 1px">{{ number_format((float)$OpenInvoice->ProjectValue, 1, '.', ',') }}</td>
			<td style="padding:3px 10px 1px">{{ $OpenInvoice->Percentage }}%</td>
			@if($OpenInvoice->License == 0)
				<td style="padding:3px 10px 1px"></td>
			@else
				<td style="padding:3px 10px 1px">{{ number_format((float)$OpenInvoice->License, 1, '.', ',') }}</td>
			@endif
			@if($OpenInvoice->Service == 0)
				<td style="padding:3px 10px 1px"></td>
			@else
				<td style="padding:3px 10px 1px">{{ number_format((float)$OpenInvoice->Service, 1, '.', ',') }}</td>
			@endif
			@if($OpenInvoice->Maintenance == 0)
				<td style="padding:3px 10px 1px"></td>
			@else
				<td style="padding:3px 10px 1px">{{ number_format((float)$OpenInvoice->Maintenance, 1, '.', ',') }}</td>
			@endif
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr >
            <th style="background-color:#ffff80; padding:3px 10px 1px; text-align:center" colspan="8">Sub Total</th>
            <th style="background-color:#ffff80; padding:3px 10px 1px"></th>
            <th style="background-color:#ffff80; padding:3px 10px 1px"></th>
            <th style="background-color:#ffff80; padding:3px 10px 1px"></th>
        </tr>
        <tr >
            <th colspan="8" style="text-align:center; padding:3px 10px 1px; background-color:#80ff80">Grand Total</th>
            @foreach($TotalOpenInvoice as $TotalOpenInvoice)
	            <th id="License" style="background-color:#80ff80; padding:3px 10px 1px">{{ number_format((float)$TotalOpenInvoice->TotalLicense, 1, '.', ',') }}</th>
	            <th id="Service" style="background-color:#80ff80; padding:3px 10px 1px">{{ number_format((float)$TotalOpenInvoice->TotalService, 1, '.', ',') }}</th>
	            <th id="Maintenance" style="background-color:#80ff80; padding:3px 10px 1px">{{ number_format((float)$TotalOpenInvoice->TotalMaintenance, 1, '.', ',') }}</th>
            @endforeach
        </tr>
    </tfoot>
</table>