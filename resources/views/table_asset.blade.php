@foreach($rolemenus as $rolemenu)
	@if ($rolemenu->Role_S == "1")
	<script src="{{asset('js/TableAsset.js')}}"></script>
	<table id="assetTable" class="table table-bordered" style="font-size:12px">
		<thead style="background-color:#ECECEC;font-weight:bold">
			<tr>
				<th style="text-align:center">Asset Number</th>
				<th style="text-align:center">Owner</th>
				<th style="text-align:center">Description</th>
				<th style="text-align:center">Asset Type</th>
				<th style="text-align:center">Location</th>
				<th style="text-align:center">Serial Number</th>
				<th style="text-align:center">Lifetime</th>
				<th style="text-align:center">Room</th>
				<th style="text-align:center">Price</th>
				<th style="text-align:center">Notes</th>
				<th style="text-align:center">Status</th>
				<th style="text-align:center">Action_Button</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 0; ?>
			@foreach($ListAsset as $Asset)
				@if($Asset->Lifetime >= 3)
					<tr>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetNumber }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->EmployeeName }}</td>
						<td style="padding:3px 10px 1px"><a role="button" data-toggle="collapse" href="#collapseAssetDesc{{ $i }}" aria-expanded="false" aria-controls="collapseAssetDesc{{ $i }}">Show Details</a><div class="collapse" id="collapseAssetDesc{{ $i }}">{{ $Asset->AssetDescription }}</div></td>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetTypeName }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->RegionName }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->SerialNumber }}</td>
						<td style="background-color: #ff4c4c; padding:3px 10px 1px"><font color="#fff">{{ $Asset->Lifetime }}</font></td>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetRoom }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->PriceBuy }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->Notes }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetStatus }}</td>
						<td style="padding:0px; text-align:center">
							<a href="/asset/history?assetnumber={{ $Asset->AssetNumber }}"><button style="padding:0px 3px" value="{{ $Asset->AssetNumber }}" class="ChooseHistoryAsset btn btn-default"><i class="fa fa-hourglass-o" aria-hidden="true"></i></button></a>
							@if($rolemenu->Role_U == "1")
							<button style="padding:0px 1px" value="{{ $Asset->TransactionAssetID }}" class="ChooseEditAsset btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
							@endif
							@if($rolemenu->Role_D == "1")
							<button style="padding:0px 3px" value="{{ $Asset->AssetNumber }}" class="ChooseDeleteAsset btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
							@endif
						</td>
					</tr>
				@else
					<tr>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetNumber }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->EmployeeName }}</td>
						<td style="padding:3px 10px 1px"><a role="button" data-toggle="collapse" href="#collapseAssetDesc{{ $i }}" aria-expanded="false" aria-controls="collapseAssetDesc{{ $i }}">Show Details</a><div class="collapse" id="collapseAssetDesc{{ $i }}">{{ $Asset->AssetDescription }}</div></td>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetClassName }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->RegionName }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->SerialNumber }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->Lifetime }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetRoom }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->PriceBuy }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->Notes }}</td>
						<td style="padding:3px 10px 1px">{{ $Asset->AssetStatus }}</td>
						<td style="padding:0px; text-align:center">
							<a href="/asset/history?assetnumber={{ $Asset->AssetNumber }}"><button style="padding:0px 3px" value="{{ $Asset->AssetNumber }}" class="ChooseHistoryAsset btn btn-default"><i class="fa fa-hourglass-o" aria-hidden="true"></i></button></a>
							@if($rolemenu->Role_U == "1")
							<button style="padding:0px 1px" value="{{ $Asset->TransactionAssetID }}" class="ChooseEditAsset btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
							@endif
							@if($rolemenu->Role_D == "1")
							<button style="padding:0px 3px" value="{{ $Asset->AssetNumber }}" class="ChooseDeleteAsset btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
							@endif
						</td>
					</tr>
				@endif
				<?php $i++; ?>
			@endforeach
		</tbody>
	</table>
	@endif
@endforeach