<script src="{{asset('js/TableAssetType.js')}}"></script>
<table id="AssetTypeTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td style="text-align:center">Asset Type ID</td>
			<td style="text-align:center">Asset Type Name</td>
			<td style="text-align:center">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListAssetType as $AssetType)
		<tr>
			<td style="padding:3px 10px 1px">{{$AssetType->AssetTypeID}}</td>
			<td style="padding:3px 10px 1px">{{$AssetType->AssetTypeName}}</td>
			<td align="center" style="padding:0px">
				<button style="padding:0px 1px" value="{{$AssetType->AssetTypeID}}" class="ChooseEditAT btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
				<button style="padding:0px 3px" value="{{$AssetType->AssetTypeID}}" class="ChooseDeleteAT btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
			</td>	
		</tr>
		@endforeach
	</tbody>
</table>