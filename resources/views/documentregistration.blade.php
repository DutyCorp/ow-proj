	@include('library.head')
	<title>Document Registration</title>
	<script src="{{asset('js/DocumentRegistration.js')}}"></script>
	<div id="main" class="container">
		<div class="modal fade" tabindex="-1" role="dialog" id="Modal_Notification">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h4 class="modal-title" id="ModalHeaderNotification"></h4>
		      		</div>
		      		<div class="modal-body" id="ModalContentNotification">

		      		</div>
		      		<div class="modal-footer" id="ModalFooter">
		      		<center>
			      		<button type="button" class="btn btn-danger" id="YesDelete">Yes</button>
			      		<button type="button" class="btn btn-default" id="NoDelete">No</button>
		      		</center>
		      	</div>
		    	</div>
		  	</div>
		</div>
		<div class="modal fade" tabindex="-1" role="dialog" id="Modal">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h4 class="modal-title" id="ModalHeader"></h4>
		      		</div>
		      		<div class="modal-body" id="ModalContent">

		      		</div>
		      		<div class="modal-footer" id="ModalFooter">
		      			<button type="button" class="btn btn-primary" id="btnAlright">OK</button>
		      		</div>
		    	</div>
		  	</div>
		</div>
		<div class="modal fade" id="ModalAddDocumentType" role="dialog">
		    <div class="modal-dialog">
		      	<div class="modal-content">
			        <div class="modal-header">
			          <center><h4 class="modal-title">New Document Type</h4></center>
			        </div>
			        <div class="modal-body">
			         	<div class="form-group row">
			         		<div class="col-md-3 col-md-offset-1">Document Type</div>
			      			<div class="col-md-6"><input type="text" id="DocumentTypeName" class="form-control"></div>
			      		</div>
			      		<div class="form-group row">
			         		<center id="Info_DocumentType" style="color:red">Total must be 100</center>
			      		</div>
			      		<div class="form-group row" align="center">
							<button class="btn btn-primary" id="buttonAddDocumentType">Submit</button>
							<button class="btn btn-success" id="buttonUpdateDocumentType">Update</button>
							<button class="btn btn-default" id="buttonCancelDocumentType">Cancel</button>
						</div>
						<div id="tableDocumentType" style="font-size=5px">

						</div>
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div>
		      	</div>
		    </div>
  		</div>
		<div class="form-group row">
			<center>
				<h1>Document Registration</h1>
			</center>
		</div>
		<div class="form-group row">
			<div class="col-md-6" style="right:-5%">
				<div class="form-group row" style="width:80%; background-color:#E3F2FD" >
					<div class="col-md-12">
						<div class="form-group row">
							<div class="col-md-12" style="padding-top:20px">
								<label for="DocumentRegion">Region</label>
								<select id="DocumentRegion" class="form-control">
									<option value="None">Select</option>
									@foreach($ListRegion as $Region)
										<option value="{{ $Region->RegionID }}">
											{{ $Region->RegionName }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-9">
								<label for="DocumentType">Document Type</label>
								<select id="DocumentType" class="form-control">
									<option value="None">Select</option>
									@foreach($ListDocumentType as $DocumentType)
										<option value="{{ $DocumentType->DocumentTypeID }}">
											{{ $DocumentType->DocumentTypeName }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-3" style="padding-top:22px">
								<button id="AddDocumentType" type="button" class="form-control btn btn-success" data-toggle="modal" data-target="#ModalAddDocumentType" style="font-size : 11px">Add Type</button>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="DocumentDate">Document Date</label>
								<input id="DocumentDate" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d/m/yyyy"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="DocumentDate">Document Description</label>
								<textarea id="DocumentDescription" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6" style="right:-5%">
				<div class="form-group row" style="width:80%; background-color:#E3F2FD" >
					<div class="col-md-12" >
						<div class="form-group row">
							<div class="col-md-12" style="padding-top:20px">
								<label for="DocumentNumber">Document Number</label>
								<input type="text" id="DocumentNumber" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="DocumentOwner">Owner</label>
								<select id="DocumentOwner" class="form-control">
									<option value="None">Select</option>
									@foreach($ListOwner as $Owner)
										<option value="{{ $Owner->EmployeeID }}">
											{{ $Owner->EmployeeName }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12">
								<label for="DocumentDestination">Attention to</label>
								<input id="DocumentDestination" class="form-control">
							</div>
						</div>
						<div class="form-group row" style="padding-bottom:40px">
							<div class="col-md-12">
								<label for="DocumentApprover">Approver</label>
								<input id="DocumentApprover" class="form-control">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group row" align="center">
			<button class="btn btn-primary" id="buttonSubmitDocumentRegistration">Submit</button>
			<button class="btn btn-default" id="buttonClearDocumentRegistration">Clear</button>
			<button class="btn btn-success" id="buttonUpdateDocumentRegistration">Update</button>
			<button class="btn btn-default" id="buttonCancelDocumentRegistration">Cancel</button>
		</div>
		@foreach($DocumentLatestDate as $DocumentDate)
			<p id="DocumentLastUpdate">Last Update : <b>{{ date('d-M-Y H:i:s', strtotime($DocumentDate->Tr_Date_I)) }}</b></p>
		@endforeach
		<div id="TableDocument">
		</div>
	</div>
	@include('library.foot')