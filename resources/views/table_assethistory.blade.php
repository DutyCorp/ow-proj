	@include('library.head')
	<title>Asset History</title>
	<script src="{{asset('js/TableAssetHistory.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
		<div id="main" class="container">
			<div class="form-group row" style="margin-top: 20px;">
				<center>
					<h1>Asset History</h1>
				</center>
			</div>
			<div>
				<div style="width: 20px; height: 20px; border: 1px solid rgba(0, 0, 0, .2); background: #f44256;"></div><label>Notebook with lifetime > 3 years</label>
			</div>		
			<div class="form-group row">
				<div class="col-md-12">
					<table id="AssetHistoryTable" class="stripe row-border order-column table table-bordered" style="font-size:12px">
						<thead style="background-color:#ECECEC;font-weight:bold">
							<tr>
								<th style="text-align:center">Asset Number</th>
								<th style="text-align:center">Asset Type</th>
								<th style="text-align:center">Description</th>
								<th style="text-align:center">Asset Class</th>
								<th style="text-align:center">Location</th>
								<th style="text-align:center">Serial Number</th>
								<th style="text-align:center">Life Time</th>
								<th style="text-align:center">Owner</th>
								<th style="text-align:center">Room</th>
								<th style="text-align:center">Price</th>
								<th style="text-align:center">Price Sell</th>
								<th style="text-align:center">Notes</th>
								<th style="text-align:center">Status</th>
								<th style="text-align:center">Updated Time</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Asset Number</th>
								<th>Asset Type</th>
								<th>Description</th>
								<th>Asset Class</th>
								<th>Location</th>
								<th>Serial Number</th>
								<th>Life Time</th>
								<th>Owner</th>
								<th>Room</th>
								<th>Price</th>
								<th>Price Sell</th>
								<th>Notes</th>
								<th>Status</th>
								<th>Updated Time</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($ListAssetHistory as $AssetHistory)
								@if($AssetHistory->Lifetime >= 3 && $AssetHistory->AssetTypeID == 'AT01')
									<tr >
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetNumber }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetTypeName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetDescription }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetClassName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->RegionName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->SerialNumber }}</td>
										<td style="padding:3px 10px 1px; background-color: #f44256"><font color="#fff">{{ $AssetHistory->Lifetime }}</font></td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->EmployeeName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetRoom }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->PriceBuy }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->PriceSell }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->Notes }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetStatus }}</td>
										<td style="padding:3px 10px 1px">{{ date('d-M-Y', strtotime($AssetHistory->Tr_Date_U)) }}</td>
									</tr>
								@else
									<tr>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetNumber }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetTypeName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetDescription }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetClassName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->RegionName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->SerialNumber }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->Lifetime }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->EmployeeName }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetRoom }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->PriceBuy }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->PriceSell }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->Notes }}</td>
										<td style="padding:3px 10px 1px">{{ $AssetHistory->AssetStatus }}</td>
										<td style="padding:3px 10px 1px">{{ date('d-M-Y', strtotime($AssetHistory->Tr_Date_U)) }}</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		@endif
	@endforeach
	@include('library.foot')