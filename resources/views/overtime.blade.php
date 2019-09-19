	@include('library.head')
	<title>Entry Overtime</title>
	<script src="{{asset('js/Overtime.js')}}"></script>
	@foreach($rolemenus as $rolemenu)
		@if ($rolemenu->Role_S == "0")
			<script>
				$(function(){
					window.location.replace("/");
				});
			</script>
		@else
			<div id="main" class="container">
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
				<div class="modal fade" tabindex="-1" role="dialog" id="Modal_Notification">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" id="ModalHeaderNotification"></h4>
							</div>
							<div class="modal-body" id="ModalContentNotification">

							</div>
							<div class="modal-footer" id="ModalFooterNotification">
								<center>
									<button type="button" class="btn btn-success" id="YesDelete">Yes</button>
									<button type="button" class="btn btn-danger" id="NoDelete">No</button>
								</center>
							</div>
						</div>
					</div>
				</div>		
				@if ($rolemenu->Role_I == "0")
					<script>
						$(function(){
							$('#insertOvertime').hide();
						});
					</script>
				@endif
				<input type="hidden" id="RoleI" value="{{ $rolemenu->Role_I }}">
				<div class="form-group row">
					<center>
						<h1>Entry Overtime</h1>
					</center>
				</div>
				<div id="insertOvertime" >
					<div class="form-group row">
						<div class="col-md-4 col-md-offset-4">
							<div class="form-group row" style="background-color:#E3F2FD" >
								<div class="col-md-12" style="padding-top: 10px">
									<div class="form-group row">
										@if(session()->get('RoleID') == "R00")
											<div class="col-md-9">
												<label for="selectEmployeeName">Employee</label>
												<select id="selectEmployeeName" class="form-control">
													<option value="None">Select</option>
													@foreach($ListEmployee as $Employee)
														@if ($Employee->EmployeeID != "EM999")
														<option value="{{ $Employee->EmployeeID }}">
															{{ $Employee->EmployeeName }}
														</option>
														@endif
													@endforeach
												</select>
											</div>
											<div class="col-md-3" style="padding-top:22px">
												<input disabled id="EmployeeID" class="form-control">
											</div>
										@else
											<div class="col-md-12">
												<label for="EmployeeID">Employee</label>
												<input disabled id="EmployeeID" value="{{ session()->get('EmployeeID') }}" class="form-control">
											</div>
										@endif
										<div class="col-md-12" style="padding-top:20px">
											<label for="selectManagerName">Coordinator</label>
											<select id="selectManagerName" class="form-control">
												<option value="None">Select</option>
												@foreach($ListCoordinator as $Coordinator)
													@if ($Coordinator->EmployeeID != "EM999")
													<option value="{{ $Coordinator->EmployeeName }}">
														{{ $Coordinator->EmployeeName }}
													</option>
													@endif
												@endforeach
											</select>
										</div>
										<div class="col-md-12" style="padding-top:20px">
											<label for="selectDate">Date</label>
											<input type='text' class='datepicker-here form-control' data-language='en' data-date-format="dd/mm/yyyy" id="selectDate">
										</div>
										<div class="col-md-12" style="padding-top:20px">
											<label for="selectOvertimeType">Type</label>
											<select id="selectOvertimeType" class="form-control">
												<option value="None">Select</option>
												@foreach($ListOTType as $Type)
													<option value="{{ $Type->OverTimeTypeID }}">{{ $Type->OverTimeTypeName }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-12" style="padding-top:20px">
											<label for="entryNotes">Notes</label>
											<textarea id="entryNotes" class="form-control" rows="5"></textarea>
										</div>
										<div class="form-group row"></div>
										<div class="col-md-12" align="center">
											<button id="buttonSubmitOvertime" class="btn btn-primary">Submit</button>
											<button id="buttonClearOvertime" class="btn btn-link">Clear</button>
											<button id="buttonUpdateOvertime" class="btn btn-success">Update</button>
											<button id="buttonCancelOvertime" class="btn btn-default">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="OvertimeLoading" class="form-group row">
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
				</div>	
				<div id="tableOvertime">
				</div>
			</div>
		@endif
	@endforeach
	@include('library.foot')