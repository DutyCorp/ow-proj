<script src="{{asset('js/TableRegionSetting.js')}}"></script>
<table id="GSTable" class="table table-bordered" style="font-size:12px">
    <thead style="background-color:#ECECEC;font-weight:bold">
        <tr>
            <th style="text-align:center">Region</th>
            <th style="text-align:center">Group Manager 1</th>
            <th style="text-align:center">Group Manager 2</th>
            <th style="text-align:center">PMO</th>
            <th style="text-align:center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ListRegions as $Region)
       		@if($Region->RegionID != "AS")
	            <tr>
	                <td style="padding:3px 10px 1px">{{ $Region->RegionName }}</td>
	                <td style="padding:3px 10px 1px">{{ $Region->GRM_1 }}</td>
	                <td style="padding:3px 10px 1px">{{ $Region->GRM_2 }}</td>
	                <td style="padding:3px 10px 1px">{{ $Region->PMO }}</td>
	                <td align="center" style="padding:0px">
	                    <button style="padding:0px 1px" value="{{ $Region->RegionID }}" class="ChooseEdit btn btn-success">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </button>
	                </td>
	            </tr>
	        @endif
        @endforeach
    </tbody>
</table>