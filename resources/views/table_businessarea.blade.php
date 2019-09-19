<script src="{{asset('js/TableBusinessArea.js')}}"></script>
<table id="BATable" class="table table-bordered">
	<thead style="background-color:#ECECEC;font-weight:bold" style="font-size:12px">
		<tr>
			<td style="text-align:center">Business Area ID</td>
			<td style="text-align:center">Business Area Name</td>
			<td style="text-align:center">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListBA as $BA)
			<tr>
				<td style="padding:3px 10px 1px">{{$BA->BusinessAreaID}}</td>
				<td style="padding:3px 10px 1px">{{$BA->BusinessAreaName}}</td>
				<td align="center" style="padding:0px">
					<button style="padding:0px 1px" value="{{$BA->BusinessAreaID}}" class="ChooseEditBA btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{$BA->BusinessAreaID}}" class="ChooseDeleteBA btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>