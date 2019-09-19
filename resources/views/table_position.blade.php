<script src="{{asset('js/TablePosition.js')}}"></script>
<table id="PositionTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td style="text-align:center">Position ID</td>
			<td style="text-align:center">Position Name</td>
			<td style="text-align:center">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListPosition as $Position)
			<tr>
				<td style="padding:3px 10px 1px">{{$Position->PositionID}}</td>
				<td style="padding:3px 10px 1px">{{$Position->PositionName}}</td>
				<td align="center" style="padding:0px">
					<button style="padding:0px 1px" value="{{$Position->PositionID}}" class="ChooseEditPosition btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{$Position->PositionID}}" class="ChooseDeletePosition btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>