	@include('library.head')
	<title>Timesheet Completion</title>
	<script src="{{asset('js/TimesheetCompletion.js')}}"></script>
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
				<div class="modal fade bs-example-modal-sm" id="LoadingModal" tabindex="-1" role="dialog" aria-labelledby="LoadingModal">
				  	<div class="modal-dialog modal-sm" role="document">
				    	<div class="modal-content">
				    		<div class="form-group row">
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
					    	<br><br><br><br><br>
					    	<div class="form-group row">
					    		<center>This may take a while. Sit back and relax</center>
					    	</div>
				    	</div>
				  	</div>
				</div>
				<div class="form-group row" style="margin-bottom:0px">
		            <center>
		                <h1>Timesheet Completion</h1>
		            </center>
		        </div>
		        <div class="form-group row"></div>
				<div class="form-group row" style="margin-bottom:10px">
					<div class="col-md-3"></div>
					<div class="col-md-2">
						<label style="background-color:#337ab7; color:#fff; text-align:center" class="form-control">Office</label>
					</div>
					<div class="col-md-2">
						<label style="background-color:#337ab7; color:#fff; text-align:center" class="form-control">Working Day</label>
					</div>
					<div class="col-md-2">
						<label style="background-color:#337ab7; color:#fff; text-align:center" class="form-control">Total Working Hours</label>
					</div>
					<div class="col-md-3"></div>
				</div>
				@foreach($ListRegion as $Region)
					@if($Region->RegionID != "AS")
						<div id="Data" class="form-group row" style="margin-bottom:0px">
							<div class="col-md-3"></div>
							<div class="col-md-2">
								<input disabled id="{{ $Region->RegionID }}" value="{{ $Region->RegionName }}" style="margin: 0px 0px 5px 0px; text-align:center" type="text" class="form-control">
							</div>
							<div class="col-md-2">
								<input id="{{ $Region->RegionID }}WorkingDay" style=" text-align:center" type="text" class="form-control WorkingDay">
							</div>
							<div class="col-md-2">
								<input disabled id="{{ $Region->RegionID }}TotalWorkingHours" type="text" class="form-control" style=" text-align:center" >
							</div>
							<div class="col-md-3"></div>
						</div>
					@endif
				@endforeach
				<div>
					<hr style="border-top: 5px double #8c8b8b;">
				</div>
				<div class="form-group row">
					@if ($rolemenu->Role_I == "1")
						<div class="col-md-3"><input id="UploadFileTimeSheetCompletion" type="file" class="form-control"></div>
						<div class="col-md-1"><button id="SubmitFileBtn" class="btn btn-primary">Submit</button></div>
					@endif
					@if ($rolemenu->Role_U == "1")
						<div id="EditEmployee" class="col-md-3 col-md-offset-3">
							<select id="selectEmployee" class="form-control">
							</select>
							<span class="help-block">Select Employee</span>
						</div>
						<div id="EditHours" class="col-md-1"><input id="EditEmployeeHours" type="text" class="form-control"><span class="help-block">Set Hours</span></div>
						<div class="col-md-1"><button id="SubmitEditBtn" class="btn btn-primary">Edit</button></div>
					@endif
				</div>
				<div class="form-group row"></div>
				<div id="table"></div>
			</div>
		@endif
	@endforeach
	@include('library.foot')