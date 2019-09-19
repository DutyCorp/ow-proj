<script src="{{asset('js/TableDocumentType.js')}}"></script>
<table id="DocumentTypeTable" class="table table-bordered" style="font-size:12px">
	<thead style="background-color:#ECECEC;font-weight:bold">
		<tr>
			<td>Document Type ID</td>
			<td>Document Type Name</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		@foreach($ListDocumentType as $DocumentType)
		<tr>
			<td style="padding:0px">{{$DocumentType->DocumentTypeID}}</td>
			<td style="padding:0px">{{$DocumentType->DocumentTypeName}}</td>
			<td style="padding:0px">
				<button value="{{$DocumentType->DocumentTypeID}}" class="ChooseEditDocumentType btn btn-success"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
				<button value="{{$DocumentType->DocumentTypeID}}" class="ChooseDeleteDocumentType btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
			</td>	
		</tr>
		@endforeach
	</tbody>
</table>