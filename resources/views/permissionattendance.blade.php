	@include('library.head')
	<title>Entry Permission</title>
	<script src="{{asset('js/EntryPermission.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
			    	window.location.replace("/");
			    });
			</script>
		@else
			<div id="main" class="container">
				<div class="modal fade" id="ModalAddPermissionType" role="dialog">
				    <div class="modal-dialog">
				      	<div class="modal-content">
					        <div class="modal-header">
					          	<center><h4 class="modal-title">Permission Type</h4></center>
					        </div>
					        <div class="modal-body">
					        	<div class="form-group row">
									<div class="col-md-4 col-md-offset-1" align="left">
										<label>Permission Type ID</label>
									</div>
									<div class="col-md-4" align="left">
										<label id="PTID"><b></b></label>
									</div>
								</div>
					         	<div class="form-group row">
					         		<div class="col-md-4 col-md-offset-1">Permission Type Name</div>
					      			<div class="col-md-6"><input type="text" id="PermissionTypeName" class="form-control"></div>
					      		</div>
					      		<div class="form-group row">
					         		<center id="Info" style="color:red">Total must be 100</center>
					      		</div>
					      		<div class="form-group row" align="center">
									<button class="btn btn-primary" id="buttonAddPermissionType">Submit</button>
									<button class="btn btn-success" id="buttonUpdatePermissionType">Update</button>
									<button class="btn btn-default" id="buttonCancelPermissionType">Cancel</button>
								</div>
								<div id="table" style="font-size=5px">
									
								</div>
					        </div>
					        <div class="modal-footer">
					          	<button id="closeButton" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
				@if ($rolemenu->Role_I == "0")
					<script>
						$(function(){
					    	$('#insertPermission').hide();
					    });
					</script>
				@endif
				<input type="hidden" id="RoleI" value="{{ $rolemenu->Role_I }}">
				<div class="form-group row">
					<center>
						<h1>Entry Permission</h1>
					</center>
				</div>
				<div id="insertPermission">
					<div class="form-group row">
						<div class="col-md-4 col-md-offset-4">
							<div class="form-group row" style="background-color:#E3F2FD" >
								<div class="col-md-12" style="padding-top: 10px">
									<div class="form-group row">
										@if(session()->get('RoleID') == "R00")
											<div class="col-md-9" align="left">
												<label for="SelectEmployeeID">Employee</label>
												<select id="SelectEmployeeID" name="SelectEmployeeID" class="form-control">
													<option value="None">Select</option>
													@foreach($ListEmployee as $Employee)
													<option value="{{ $Employee->EmployeeID }}">{{ $Employee->EmployeeName }}</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-3" align="left" style="padding-top:22px">
												<input type="text" disabled id="EmployeeID" name="EmployeeID" class="form-control">
											</div>
										@else
											<label for="EmployeeID">Employee</label>
											<div class="col-md-12" align="left">
												<input disabled type="text" id="EmployeeID" name="EmployeeID" class="form-control" value="{{ session()->get('EmployeeID') }}">
											</div>
										@endif
										<div class="col-md-12" align="left">
											<label for="coorID">Coordinator</label>
											<select id="coorID" class="form-control">
												<option value="None">Select</option>
												@foreach($ListEmployee as $Employee)
													<option value="{{ $Employee->EmployeeID }}">{{ $Employee->EmployeeName }}</option>
												@endforeach
											</select>
										</div>
										<input type="hidden" id="permitID">
										<div class="col-md-12">
											<label for="permitDate">Date</label>
											<input id="permitDate" type="text" class="datepicker-here form-control" data-language='en' data-date-format="d/m/yyyy"/>
										</div>
										<div class="col-md-9">
											<label for="permitType">Permission Type</label>
											<select id="permitType" name="permitType" class="form-control">
												<option value="None">Select</option>
												@foreach($ListPermissionType as $PermissionType)
													<option value="{{ $PermissionType->PermissionID }}">{{ $PermissionType->PermissionType }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-3" style="padding-top:22px">
											<button id="AddPT" class="btn-success btn form-control" data-toggle="modal" data-target="#ModalAddPermissionType">Add</button>
										</div>
										<div class="col-md-12">
											<label for="permitNotes">Notes</label>
											<textarea id="permitNotes" name="permitNotes" class="form-control" rows="5"></textarea>
										</div>
										<div class="form-group row"></div>
										<div class="col-md-12" align="center">
											<button id="buttonSubmit" class="btn btn-primary">Submit</button>
											<button id="buttonClear" class="btn btn-link">Clear</button>
											<button id="buttonUpdate" class="btn btn-success">Update</button>
											<button id="buttonCancel" class="btn btn-default">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				<div class="loader">
					<div class="loader-inner">
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
						<div class="loader-line-wrap">
							<div class="loader-line"></div>
						</div>
					</div>
				</div>
				<div id="tablePermission">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')