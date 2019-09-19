<table id="RP_Table" class="table table-bordered" style="font-size: 12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<th style="text-align:center">Description</th>
			@foreach($DateData as $DD)
				<th style="text-align:center">{{ $DD }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="padding:3px 10px 1px">ID Working Day</td>
			@foreach($DateData as $DD)
				<td style="padding:3px 10px 1px" align="center"><input class="IDWD form-control" type="text" style="width:75px"></td>
			@endforeach
		</tr>
		<tr>
			<td style="padding:3px 10px 1px">MY Working Day</td>
			@foreach($DateData as $DD)
				<td style="padding:3px 10px 1px" align="center"><input class="MYWD form-control" type="text" style="width:75px"></td>
			@endforeach
		</tr>
		<tr>
			<td style="padding:3px 10px 1px">TH Working Day</td>
			@foreach($DateData as $DD)
				<td style="padding:3px 10px 1px" align="center"><input class="THWD form-control" type="text" style="width:75px"></td>
			@endforeach
		</tr>
		<tr>
			<td style="padding:3px 10px 1px">VN Working Day</td>
			@foreach($DateData as $DD)
				<td style="padding:3px 10px 1px" align="center"><input class="VNWD form-control" type="text" style="width:75px"></td>
			@endforeach
		</tr>
	</tbody>
</table>