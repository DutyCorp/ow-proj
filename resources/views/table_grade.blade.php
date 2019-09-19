<script src="{{asset('js/TableGrade.js')}}"></script>
<table id="GradeTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td style="text-align:center">Grade ID</td>
			<td style="text-align:center">Department Name</td>
			<td style="text-align:center">Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListGrade as $Grade)
			<tr>
				<td style="padding:3px 10px 1px">{{$Grade->GradeID}}</td>
				<td style="padding:3px 10px 1px">{{$Grade->GradeName}}</td>
				<td align="center" style="padding:0px">
					<button style="padding:0px 1px" value="{{$Grade->GradeID}}" class="ChooseEditGrade btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
					<button style="padding:0px 3px" value="{{$Grade->GradeID}}" class="ChooseDeleteGrade btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
				</td>	
			</tr>
		@endforeach
	</tbody>
</table>